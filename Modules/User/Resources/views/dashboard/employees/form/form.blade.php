@inject("roles", "Modules\Authorization\Repositories\Dashboard\RoleRepository")
@inject("sellers", "Modules\User\Repositories\Dashboard\SellerRepository")
{!! field()->text('name',__('user::dashboard.admins.create.form.name'))!!}
{!! field()->email('email',__('user::dashboard.admins.create.form.email'))!!}
{!! field()->text('mobile',__('user::dashboard.admins.create.form.mobile'))!!}
{!! field()->password('password',__('user::dashboard.admins.create.form.password'))!!}
{!! field()->password('confirm_password',__('user::dashboard.admins.create.form.confirm_password'))!!}
{!! field()->file('image',__('user::dashboard.admins.create.form.image'),$model?$model->getFirstMediaUrl('images'):'')!!}
{!! field()->select('seller_id',__('user::dashboard.sellers.index.title'),$sellers->getSellers())!!}

<div class="form-group">
    <label class="col-md-2">
        {{__('user::dashboard.admins.create.form.roles')}}
    </label>
    <div class="col-md-9">
        <div class="mt-checkbox-list">
            @foreach ($roles->getAllSellerRoles('id', 'asc') as $role)
            <label class="mt-checkbox">
                <input type="checkbox"
                    name="roles[]"
                    @if(
                    optional($model)->hasRole($role->name))
                checked
                @endif
                value="{{$role->id}}">
                {{$role->display_name}}
                <span></span>
            </label>
            @endforeach
        </div>
    </div>
</div>

@can('two_factor')
@php
    $google2fa = new PragmaRX\Google2FAQRCode\Google2FA();
    $key = $model->google_2fa ? $model->google_2fa : $google2fa->generateSecretKey();
@endphp
<input type="hidden" name="google_2fa" value="{{$key}}">
<div class="form-group">
    <label class="col-md-2">
        {{ __('user::dashboard.admins.create.form.2fa_authentication') }}
    </label>
    <div class="col-md-3">
        <input type="checkbox" class="" id="two_factor" data-size="small"
               name="two_factor" {{$model && $model->id ? ($model->two_factor ? 'checked' : '') : ''}}>
        <div class="help-block"></div>
    </div>
    <div class="col-md-3 codes {{$model->two_factor ? '' : 'hidden'}}">
        @if(env('APP_ENV') == 'local')
            <img src="{!! $google2fa->getQRCodeInline($model->name,$model->email,$key) !!}" alt="qrCode2FA">
        @else
            {!! $google2fa->getQRCodeInline($model->name,$model->email,$key) !!}
        @endif
        <p>{{ __('user::dashboard.admins.create.form.2fa_authentication_p') }}</p>
    </div>
</div>

@section('scripts')
    <script>
        $(function (){
            $('#two_factor').bootstrapSwitch({
                onSwitchChange: function (event, state){
                    $('.codes').toggleClass('hidden');
                }
            })
        });
    </script>
@endsection
@endif
