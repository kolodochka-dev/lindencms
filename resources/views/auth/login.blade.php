@extends('cms::auth.app')

@section('title', 'Login — LindenCMS')

@section('content')
<div class="relative min-h-screen flex items-center justify-center px-4 py-12 overflow-hidden bg-gradient-to-br from-primary-50 via-back-50 to-secondary-50">
    {{-- Animated floating orbs --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-[600px] h-[600px] bg-primary-200/30 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-60 -left-60 w-[700px] h-[700px] bg-secondary-200/25 rounded-full blur-3xl animate-pulse delay-1000"></div>
        <div class="absolute top-1/3 right-1/4 w-80 h-80 bg-accent-100/20 rounded-full blur-3xl animate-pulse delay-2000"></div>
        <div class="absolute bottom-1/4 left-1/3 w-96 h-96 bg-primary-100/25 rounded-full blur-3xl"></div>
        
        {{-- Floating particles --}}
        @for($i = 0; $i < 16; $i++)
            <div class="absolute w-1.5 h-1.5 bg-primary-400/60 rounded-full animate-float"
                 style="top: {{ random_int(5, 95) }}%; left: {{ random_int(5, 95) }}%; animation-delay: {{ random_int(0, 6000) }}ms; animation-duration: {{ random_int(4000, 10000) }}ms;">
            </div>
        @endfor
    </div>

    {{-- Main card --}}
    <div class="-mt-20 relative w-full max-w-4xl bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl overflow-hidden border border-primary-200/40">
        <div class="flex flex-col md:flex-row">
            
            {{-- Left: Branding --}}
            <div class="w-full md:w-6/12 border-r border-primary-200/40 bg-gradient-to-br from-primary-100/40 via-primary-50/30 to-back-100/50 p-8 md:p-10 flex flex-col relative overflow-hidden">
                <div class="relative z-10 flex flex-col h-full">
                    <div class="flex items-center gap-3">
                        {{-- Linden leaf / tree silhouette --}}
                        <div>
                            <h1 class="bg-gradient-to-b from-secondary to-primary bg-clip-text text-transparent">LindenCMS</h1>
                        </div>
                    </div>
                    
                    {{-- Decorative line --}}
                    <div class="w-64 h-px bg-gradient-to-r from-primary-300 to-transparent my-4 mb-8"></div>
                    
                    {{-- Greeting --}}
                    <div class="space-y-1">
                        <h3>Welcome</h3>
                        <div class="space-y-4">
                            <!-- <p class="text-sm text-text-secondary">
                                Sign in to your dashboard to start managing your content with ease.
                            </p> -->
                            <p class="text-xs text-gray-400">
                                This is the <b class="text-gray-500">BETA</b> release of the LindenCMS project.
                                Feel free to ask questions on
                                <a href="https://github.com/kolodochka-dev" class="text-primary-500 hover:text-primary-600 transition-colors" target="_blank" rel="noopener noreferrer">GitHub</a> 
                                or reach out via 
                                <a href="mailto:kolodochka.alesha@gmail.com" class="text-primary-500 hover:text-primary-600 transition-colors">email</a>. 
                            </p>
                            <p class="text-xs text-gray-500">
                                Thanks for testing!
                            </p>
                        </div>
                    </div>
                    
                    {{-- Footer links (docs/website) --}}
                    <div class="mt-auto">
                        <div class="flex gap-4 text-xs">
                            <a href="#" class="text-text-tertiary hover:text-primary-600 transition-colors">Documentation</a>
                            <span class="text-border-300">|</span>
                            <a href="https://github.com/kolodochka-dev" target="_blank" class="text-text-tertiary hover:text-primary-600 transition-colors">GitHub</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: Login form --}}
            <div class="w-full p-8 md:p-10 bg-white">
                <div class="w-full">
                    {{-- Form header --}}
                    <div class="mb-4">
                        <h3 class="text-xl font-semibold text-text-primary">Sign in</h3>
                        <p class="text-text-tertiary text-sm mt-0.5">Enter your credentials to continue</p>
                    </div>

                    {{-- Error message --}}
                    @if ($errors->any())
                        <div role="alert" class="alert alert-error bg-error-50 border border-error-200 text-error-700 mb-4">
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    {{-- Login form --}}
                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf

                        {{-- Email field --}}
                        <div>
                            <label class="block text-sm font-medium text-text-secondary mb-1">Email address</label>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                class="input input-sm w-full bg-white focus:input-primary"
                                placeholder="hello@lindencms.com">
                        </div>

                        {{-- Password field --}}
                        <div>
                            <div class="flex justify-between mb-1">
                                <label class="text-sm font-medium text-text-secondary">Password</label>
                                <!-- @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-xs text-primary-500 hover:text-primary-600 transition-colors">Forgot password?</a>
                                @endif -->
                            </div>
                            <input type="password" name="password" required
                                class="input input-sm w-full bg-white focus:input-primary"
                                placeholder="••••••••">
                        </div>

                        {{-- Remember me --}}
                        <label class="flex items-center gap-2 cursor-pointer py-1">
                            <input type="checkbox" name="remember" class="checkbox checkbox-primary checkbox-xs text-white rounded">
                            <span class="text-xs text-text-tertiary">Keep me signed in</span>
                        </label>

                        {{-- Submit button --}}
                        <button type="submit" class="btn btn-primary w-full rounded-lg text-white font-medium gap-2 mt-4">
                            Sign in
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
@keyframes float {
    0%, 100% { transform: translateY(0px) translateX(0px); opacity: 0.2; }
    50% { transform: translateY(-25px) translateX(10px); opacity: 0.6; }
}
.animate-float { animation: float 6s ease-in-out infinite; }
.delay-1000 { animation-delay: 1s; }
.delay-2000 { animation-delay: 2s; }
</style>