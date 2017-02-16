<div class="table-responsive">
  <table class="table" id="table-purchase-invoice-payment-transfer">
    <thead>
      <tr>
        <th>No</th>
        <th>Payment Date</th>
        <th>Amount</th>
      </tr>
    </thead>
    <tbody>
      
        @if($purchase_order->purchase_order_invoice->purchase_invoice_payment->count())

          <?php  $payment_row = 0; ?>
          @foreach($purchase_order->purchase_order_invoice->purchase_invoice_payment as $payment)
          <tr>
            <td>{{ $payment_row +=1 }}</td>
            <td>{{ $payment->created_at }}</td>
            <td>{{ number_format($payment->amount) }}</td>
          </tr>
          @endforeach
        @endif
      
    </tbody>
  </table>
</div>