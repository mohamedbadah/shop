<x-front-layout title="two-factor">
    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    @if ($errors->has(config('fortify.username')))
                        <div class="alert alert-danger">
                            {{$errors->first(config('fortify.username'))}}
                        </div>
                    @endif
                    <form action="{{route('two-factor.enable')}}" class="card login-form" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="title">
                                <h3>two factor enable</h3>
                                <p>You can login using your social media account or email address.</p>
                            </div>
                            @if (session('status') == 'two-factor-authentication-enabled')
                                <div class="mb-4 font-medium text-sm">
                                    Please finish configuring two factor authentication below.
                                </div>
                            @endif
                            @if (Auth::user()->two_factor_recovery_codes)
                            <ul>
                                @foreach (Auth::user()->recoveryCodes() as $code)
                                    <li>{{$code}}</li>
                                @endforeach
                            </ul> 
                            @endif
                          
                           
                            <div class="button">
                                @if (!Auth::user()->two_factor_secret)
                                <button class="btn" type="submit">Enable</button> 
                                @else
                                {!! Auth::user()->twoFactorQrCodeSvg() !!}
                                @method("delete")
                                <button class="btn mt-5" type="submit">disbale</button>
                             @endif
                            </div>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-front-layout>