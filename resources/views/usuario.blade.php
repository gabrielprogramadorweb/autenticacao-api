<!-- Dentro da tag auth vai conter os dados visiveis apenas para quem estar logado -->

@auth

    <h4>Você está logado</h4>
    <p> {{ Auth::user()->name }} </p>
    <p> {{ Auth::user()->email }} </p>
    <p> {{ Auth::user()->id }} </p>

@endauth

<!-- Dentro da tag guest vai conter os dados visiveis apenas para quem estar deslogado -->

@guest
    <h4>Você não está logado!</h4>
@endguest