<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiHASAN</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{asset('../../assets/css/login.css')}}" rel="stylesheet">
    <link rel="icon" href="{{asset('../../assets/img/logo.png')}}">
</head>

<body>
    <div class="container-fluid px-1 px-md-5 px-lg-1 px-xl-5 py-5 mx-auto">
        <div class="card card0 border-0 absolute">
            <div class="row d-flex my-auto">
                <div class="col-lg-6">
                    <div class="card1 pb-5">
                        <div class="row mx-5 pt-3 mt-1">
                            <img src="{{asset('../../assets/img/logo.png')}}" class="logo">
                        </div>
                        <div class="row px-3 justify-content-center mt-5 mb-3 border-line">
                            <img src="{{asset('../../assets/img/login-img.png')}}" class="image">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card2 card border-0 px-4 py-4">
                        <div class="row mb-3 px-3 content-hiding">
                            <div class="col-md-4">
                                <img src="{{asset('../../assets/img/pi-logo.png')}}" height="50" class="text-center content-hiding">
                            </div>
                            <div class="col-md-4">
                                <img src="{{asset('../../assets/img/petro-logo.png')}}" height="50" class="text-center content-hiding">
                            </div>
                            <div class="col-md-4 d-flex align-items-center">
                                <img src="{{asset('../../assets/img/bumn-logo.png')}}" height="24" class="text-center content-hiding">
                            </div>
                        </div>
                        <div class="row px-3 mb-4 content-hiding">
                            <div class="line"></div>
                        </div>
                        <div class="alert alert-primary text-center mb-2 mt-2">
                            <b>Silahkan login menggunakan akun yang diberikan oleh Admin</b>
                        </div>
                        @if (session()->has('message'))
                        <div class="alert alert-danger text-center mb-0"><b>{!! session('message') !!}</b></div>
                        @endif
                        <form action="{{route('logon')}}" method="post">
                            <div class="row mb-3">
                                @csrf
                                <div class="col-md-12 mb-1">
                                    <label class="col-form-label" for="nik"><b>nik</b></label>
                                    <input type="text" class="form-control @error('nik') is-invalid @enderror" value="{{old('nik')}}" id="nik" name="nik" placeholder="nik" style="font-size: 12px; height: 40px">
                                    @error('nik')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="col-form-label" for="password"><b>Password</b></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" value="{{old('password')}}" id="password" name="password" placeholder="Password" style="font-size: 12px; height: 40px">
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3 px-3">
                                <button type="submit" class="btn btn-success" style="font-size: 14px; width:100%">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="bg-blue py-4">
                <div class="row px-3">
                    <span class=""><strong>Copyright &copy; 2022 Departemen Pengadaan Jasa.</strong>
                        All rights reserved.</span>
                </div>
            </div>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>

</html>