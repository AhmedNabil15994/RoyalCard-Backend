<html>
    @section('title',__('authentication::dashboard.login.routes.index'))
    <link rel="stylesheet" href="{{ asset('admin/assets/pages/css/login.min.css') }}">
    @include('apps::dashboard.layouts._head_ltr')
    <body class="login">
        <div class="content">
            <form class="login-form" action="{{ route('dashboard.auth.post_verify') }}" method="POST">
                {{ csrf_field() }}

                <h3 class="form-title font-green">{{ __('authentication::dashboard.login.routes.index') }}</h3>
                <div class="form-group{{ $errors->has('one_time_password') ? ' has-error' : '' }}">
                    <label class="control-label">
                        {{ __('authentication::dashboard.login.form.one_time_password') }}
                    </label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="text" value="{{ old('one_time_password') }}" name="one_time_password"/>
                    @if ($errors->has('one_time_password'))
                        <span class="help-block">
                        <strong>{{ $errors->first('one_time_password') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn green uppercase">
                      {{ __('authentication::dashboard.login.form.btn.login') }}
                    </button>
                </div>
            </form>
        </div>
        @include('apps::dashboard.layouts._footer')
        @include('apps::dashboard.layouts._jquery')
    </body>
</html>
