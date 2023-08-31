@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registrarse') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                    <label for="document_type" class="col-md-6 col-form-label ">{{ __('Tipo de documento') }}</label>
                                    <div>
                                        <input id="document_type" type="text" class="form-control @error('document_type') is-invalid @enderror" name="document_type" value="{{ old('document_type') }}" required autocomplete="username" autofocus>
                                        @error('document_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <label for="document_number" class="col-md-6 col-form-label ">{{ __('Numero Documento') }}</label>
                                    <div>
                                        <input id="document_number" type="number" class="form-control @error('document_number') is-invalid @enderror" name="document_number" value="{{ old('document_number') }}" required autocomplete="document_number" autofocus>
                                        @error('document_number')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="col-md-2 col-form-label ">{{ __('Nombre') }}</label>
                                <div>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="lastname" class="col-md-2 col-form-label ">{{ __('Apellido') }}</label>
                                <div>
                                    <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname" autofocus>
                                    @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="birthdate" class="col-md-6 col-form-label ">{{ __('Fecha de nacimiento') }}</label>
                                <div>
                                    <input id="birthdate" type="date" class="form-control @error('birthdate') is-invalid @enderror" name="birthdate" value="{{ old('birthdate') }}" required autocomplete="birthdate" autofocus>
                                    @error('birthdate')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="city_id" class="col-md-6 col-form-label">{{ __('Ciudad Nacimiento') }}</label>
                                <div>
                                    <select required class="form-control @error('city') is-invalid @enderror" name="city_id" id="city_id">
                                        <option selected disabled>--Selecionar Ciudad--</option>
                                        @foreach($ciudades as $ciudad)
                                            <option value="{{$ciudad->id}}">{{$ciudad->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('city_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                    <label for="username" class="col-md-4 col-form-label ">{{ __('Apodo Usuario') }}</label>
                                    <div>
                                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                                        @error('username')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="col-md-6 col-form-label">{{ __('Correo Eléctronico') }}</label>
                                <div>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="col-md-6 col-form-label ">{{ __('Contraseña') }}</label>
                               <div>
                                   <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                   @error('password')
                                   <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                   @enderror
                               </div>
                            </div>
                            <div class="col-md-6">
                                <label for="password-confirm" class="col-md-6 col-form-label ">{{ __('Confirmar Contraseña') }}</label>
                                <div>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-5 offset-md-5">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Registrarse') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
