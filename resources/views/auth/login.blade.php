<x-layout title="Login SIAKAD">

    <div class="row justify-content-center align-items-center" style="min-height: 70vh;">

        <div class="col-12 col-sm-9 col-md-6 col-lg-4">

            <div class="card shadow-sm">
                <div class="card-body p-4 p-md-5">

                    <div class="text-center mb-4">
                        <i class="bi bi-mortarboard-fill text-primary" style="font-size: 3rem;"></i>

                        <h3 class="fw-bold mt-2">Login SIAKAD</h3>
                        <p class="text-muted small">
                            Silakan masuk menggunakan akun Anda.
                        </p>
                    </div>

                    <form action="{{ route('auth.login.submit') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="login" class="form-label">
                                Username atau Email
                            </label>

                            <input type="text" name="login" id="login" value="{{ old('login') }}"
                                class="form-control @error('login') is-invalid @enderror"
                                placeholder="Masukkan username atau email" autocomplete="username" required>

                            @error('login')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">
                                Password
                            </label>

                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="Masukkan password" autocomplete="current-password" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-box-arrow-in-right me-1"></i>
                            Login
                        </button>
                    </form>

                    <p class="text-muted text-center small mt-4 mb-0">
                        Akun diberikan oleh administrator sekolah.
                    </p>

                </div>
            </div>

        </div>
    </div>

</x-layout>