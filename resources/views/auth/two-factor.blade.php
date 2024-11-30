@extends('layouts.guest2')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-50 to-pink-50 p-6">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 transform hover:scale-[1.01] transition-all">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <div class="bg-gradient-to-r from-violet-500 to-fuchsia-500 bg-clip-text">
                <h1 class="text-3xl font-bold text-transparent">
                    Verificação
                </h1>
            </div>
            <p class="mt-3 text-gray-500 text-sm">
                Confirme sua identidade inserindo o código enviado ao seu e-mail
            </p>
        </div>

        <!-- Form Section -->
        <form action="{{ route('auth.two-factor') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="space-y-2">
                <div class="flex gap-2 justify-center">
                    @for ($i = 1; $i <= 6; $i++)
                    <input
                        type="text"
                        name="code_digit_{{$i}}"
                        maxlength="1"
                        class="w-12 h-12 text-center text-lg font-semibold rounded-xl border-2 border-gray-200 focus:border-violet-500 focus:ring focus:ring-violet-200 transition-all outline-none"
                        oninput="if(this.value.length === 1) { if(this.nextElementSibling) this.nextElementSibling.focus() }"
                        onkeydown="if(event.key === 'Backspace' && !this.value && this.previousElementSibling) this.previousElementSibling.focus()"
                    >
                    @endfor
                </div>
                
                <input type="hidden" name="two_factor_code" id="two_factor_code">
                
                @error('two_factor_code')
                <p class="text-center text-sm text-rose-500 mt-2">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full py-3 px-6 text-white font-medium rounded-xl bg-gradient-to-r from-violet-500 to-fuchsia-500 hover:opacity-90 transform hover:-translate-y-0.5 transition-all duration-200 focus:ring-2 focus:ring-offset-2 focus:ring-violet-500"
                onclick="combineInputs()"
            >
                Confirmar Código
            </button>

            <!-- Help Text -->
            <p class="text-center text-sm text-gray-500 mt-4">
                Não recebeu o código? 
                <a href="#" class="text-violet-600 hover:text-violet-700 font-medium">
                    Reenviar
                </a>
            </p>
        </form>
    </div>
</div>

<script>
function combineInputs() {
    const inputs = document.querySelectorAll('input[name^="code_digit_"]');
    const combined = Array.from(inputs).map(input => input.value).join('');
    document.getElementById('two_factor_code').value = combined;
}
</script>

<style>
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Firefox */
input[type=number] {
    -moz-appearance: textfield;
}
</style>
@endsection