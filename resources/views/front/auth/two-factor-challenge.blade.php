<x-front-layout title="two-factor-challenge">
    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    @if ($errors->has(config('fortify.username')))
                        <div class="alert alert-danger">
                            {{$errors->first(config('fortify.username'))}}
                        </div>
                    @endif
                    <form action="{{route('two-factor.login')}}" class="card login-form" method="post">
                        @csrf
                        @if ($errors->has('code'))
                            <div class="alert alert-danger">
                                {{$errors->first("code")}}
                            </div>
                        @endif
                        <div class="card-body">
                            <div class="title">
                                <h3>challenge Now</h3>
                                <p>You can login using your social media account or email address.</p>
                            </div>
                            <div class="form-group input-group">
                                <label for="reg-fn">code</label>
                                <input class="form-control" name="code" type="text" id="reg-email">
                            </div>

                            <div class="form-group input-group">
                                <label for="reg-fn">recevory code</label>
                                <input class="form-control" name="recovery_code" type="text" id="reg-email">
                            </div>
                            <div class="button">
                                <button class="btn" type="submit">Login</button>
                            </div>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-front-layout>