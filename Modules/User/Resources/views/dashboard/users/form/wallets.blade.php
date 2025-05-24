<div class="portlet-title" style="margin-bottom: 25px">
    <div class="caption font-dark">
        <i class="icon-settings font-dark"></i>
        <span class="caption-subject bold uppercase">
            {{ __('user::dashboard.users.update.form.wallets') }}
      </span>
    </div>
</div>
<div class="portlet-body">
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>{{__('user::dashboard.users.update.form.country')}}</th>
            <th>{{__('user::dashboard.users.update.form.balance')}}</th>
            <th>{{__('transaction::dashboard.transactions.datatable.created_at')}}</th>
            <th>{{__('transaction::dashboard.transactions.datatable.options')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($userData['wallets'] as $wallet)
            <tr>
                <td>{{$wallet->id}}</td>
                <td>{{$wallet->country->title}}</td>
                <td>{{number_format($wallet->balance,3)}}</td>
                <td>{{$wallet->created_at}}</td>
                <td>
                    @can('edit_users')
                        <a href="#" class="btn btn-sm addBalance blue" data-area="{{$wallet->id}}" title="{{__('user::dashboard.users.update.form.add_balance')}}">
                            <i class="fa fa-edit"></i>{{__('user::dashboard.users.update.form.add_balance')}}
                        </a>
                    @endcan
                    @can('show_transactions')
                        <a href="{{route('dashboard.wallets.transactions')}}?wallet={{$wallet->id*34567}}" class="btn btn-sm yellow" data-area="{{$wallet->id}}" title="{{__('user::dashboard.users.update.form.transactions')}}">
                            <i class="fa fa-eye"></i>{{__('transaction::dashboard.transactions.index.title')}}
                        </a>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="modal balanceModal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('user::dashboard.users.update.form.add_balance')}}</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-md-2">
                        {{__('user::dashboard.users.update.form.balance')}}
                    </label>
                    <div class="col-md-9 disParent">
                        <input type="text" class="form-control" name="balance" autocomplete="off" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary acceptBalance">{{__('user::dashboard.users.update.form.add_balance')}}</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('apps::dashboard.buttons.cancel')}}</button>
            </div>
        </div>
    </div>
</div>
