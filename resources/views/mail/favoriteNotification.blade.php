<?php
/** @var \App\Domain\User\User $user */
/** @var \App\Domain\Shopify\Product $product */
/** @var \App\Domain\Shopify\Product[] $favoritedProducts */
/** @var string $action */
?>

@component('mail::message')
<h1>Send4 - Notificação de Favoritos</h1>
<h3>Olá {{ $user->name }}.</h3>

<p>O produto <strong>{{ $product->title }}</strong> foi {{ $action }} e estamos notificando isso para você</p>

<h3>Veja sua lista de Produtos Favoritos</h3>

<ul style="list-style-type: none">
@forelse ($favoritedProducts as $product)
    <li style="width: 50%; text-align: center">
        <img src="{{ $product['image']->src }}" alt="{{ $product['title'] }}" width="150">
        <hr>
        <h3 style="text-align: center">{{ $product['title'] }}</h3>
    </li>
@empty
    <li style="text-align: center">Você não possui nenhum favorito.</li>
@endforelse
</ul>

@endcomponent
