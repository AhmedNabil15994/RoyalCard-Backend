<div class="portlet-title" style="margin-bottom: 25px">
    <div class="caption font-dark">
        <i class="icon-settings font-dark"></i>
        <span class="caption-subject bold uppercase">
            {{ __('user::dashboard.users.update.form.wallets_transactions') }}
      </span>
    </div>
</div>
<div class="portlet-body">
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>{{__('transaction::dashboard.transactions.datatable.payment_id')}}</th>
            <th>{{__('transaction::dashboard.transactions.datatable.method')}}</th>
            <th>{{__('transaction::dashboard.transactions.datatable.result')}}</th>
            <th>{{__('transaction::dashboard.transactions.datatable.track_id')}}</th>
            <th>{{__('transaction::dashboard.transactions.datatable.ref')}}</th>
            <th>{{__('order::dashboard.orders.datatable.total')}}</th>
            <th>{{__('transaction::dashboard.transactions.datatable.type')}}</th>
            <th>{{__('transaction::dashboard.transactions.datatable.created_at')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($userData['wallets_transactions'] as $walletTransaction)
            @php
                $type = $walletTransaction->method == 'wallet' ? __('user::dashboard.users.update.form.out') : __('user::dashboard.users.update.form.in');
                $total = $walletTransaction->method == 'wallet' ?
                            number_format($walletTransaction->order->total,3) . ' ' . $walletTransaction?->order?->country?->currency?->code :
                                number_format($walletTransaction->recharge_balance, 3) . ' ' . $walletTransaction?->wallet?->country?->currency?->code;
            @endphp
            <tr>
                <td>{{$walletTransaction->id}}</td>
                <td>{{$walletTransaction->payment_id}}</td>
                <td>{{$walletTransaction->method}}</td>
                <td>{{$walletTransaction->result == 'paid' ? 'CAPTURED' : $walletTransaction->result}}</td>
                <td>{{$walletTransaction->track_id}}</td>
                <td>{{$walletTransaction->ref}}</td>
                <td>{{$total}}</td>
                <td>{{$type}}</td>
                <td>{{$walletTransaction->created_at}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
