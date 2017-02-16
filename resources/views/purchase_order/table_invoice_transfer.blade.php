<div class="table-responsive">
  <table class="table" id="table-purchase-invoice-payment-transfer">
    <thead>
      <tr>
        <th>No</th>
        <th>Bank Name</th>
        <th>Account Number</th>
        <th>Amount</th>
        <th>Payment Date</th>
      </tr>
    </thead>
    <tbody>
      
        @if($purchase_order->purchase_order_invoice->purchase_invoice_payment->count())

          <?php  $payment_row = 0; ?>
          @foreach($purchase_order->purchase_order_invoice->purchase_invoice_payment as $payment)
          <tr>
            <td>{{ $payment_row +=1 }}</td>
            <td></td>
            <td></td>
            <td>{{ number_format($payment->amount) }}</td>
            <td>{{ $payment->created_at }}</td>
          </tr>
          @endforeach
        @endif
      
    </tbody>
  </table>
</div>