namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrdersExport implements FromView
{
    private $fromDate;
    private $toDate;

    public function __construct($fromDate, $toDate)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }

    public function view(): View
    {
        $query = Order::query();

        // Apply date filter if dates are provided
        if ($this->fromDate && $this->toDate) {
            $query->whereBetween('created_at', [
                $this->fromDate . ' 00:00:00',
                $this->toDate . ' 23:59:59'
            ]);
        }

        $orderdetails = $query->get();

        $totalPurchaseCost = \DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereIn('orders.status', [5, 8])
            ->select(\DB::raw('SUM(COALESCE(products.purchase_price, 0) * order_items.qty) as total_purchase_cost'))
            ->whereBetween('orders.created_at', [
                $this->fromDate . ' 00:00:00',
                $this->toDate . ' 23:59:59'
            ])
            ->first();

        return view('exports.sales_report', [
            'orderdetails' => $orderdetails,
            'totalPurchaseCost' => $totalPurchaseCost,
        ]);
    }
}
