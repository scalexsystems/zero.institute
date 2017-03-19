<ul class="nav nav-justified">
    <li class="nav-item">
        <a href="#cards" data-toggle="tab" class="nav-link fee-payment-link p-2 active">
            <div class="text-center"><img src="{{ 'img/web/pricing/icons/card.svg' }}"></div> <div class="text-center small"> Cards </div>
        </a>
    </li>
    <li class="nav-item ">
        <a href="#net-banking" data-toggle="tab" class="nav-link fee-payment-link p-2">
            <div class="text-center"><img src="{{ 'img/web/pricing/icons/net-banking.svg' }}"></div> <div class="text-center small"> Net Banking </div>
        </a>
    </li>
    <li class="nav-item ">
        <a href="#upi" data-toggle="tab" class="nav-link fee-payment-link p-2 ">
            <div class="text-center"><img src="{{ 'img/web/pricing/icons/upi.svg' }}"></div> <div class="text-center small"> UPI </div>
        </a>
    </li>
    <li class="nav-item ">
        <a href="#wallet" data-toggle="tab" class="nav-link fee-payment-link p-2 ">
            <div class="text-center"><img src="{{ 'img/web/pricing/icons/wallet.svg' }}"></div> <div class="text-center small"> Wallets </div>
        </a>
    </li>
</ul>

<div class="tab-content">
    <div id="cards" class="tab-pane active">
        <div class="image-wrapper p-5">
            <img src="{{ asset('img/web/pricing/cards.png') }}">
        </div>


    </div>

    <div id="net-banking" class="tab-pane ">
        <div class="image-wrapper p-5">
            <img src="{{ asset('img/web/pricing/netb.png') }}">
        </div>

    </div>

    <div id="upi" class="tab-pane ">
        <div class="image-wrapper p-5">
            <img src="{{ asset('img/web/pricing/upi.png') }}">
        </div>
    </div>

    <div id="wallet" class="tab-pane">
        <div class="image-wrapper p-5">
            <img src="{{ asset('img/web/pricing/wallet.png') }}">
        </div>
    </div>

</div>

<style lang="scss" scoped>
    .fee-payment-link {
        background-color: #f7f7f7;
        color: black;
        border: 1px solid #e7e7e7;
        min-height: 3.5rem;
    }

    .active {
        background-color: white;
    }

    .image-wrapper img{
        width: 100%;
    }
</style>