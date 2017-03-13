<div class="nav nav-justified">
    <li class="nav-item">
        <a href="#cards" data-toggle="tab" class="nav-link fee-payment-link p-3 active">
            <div class="text-center"><img src="{{ 'img/web/pricing/icons/Card.svg' }}"></div> <div class="text-center"> Cards </div>
        </a>
    </li>
    <li class="nav-item ">
        <a href="#net-banking" data-toggle="tab" class="nav-link fee-payment-link p-1 ">
            <div class="text-center"><img src="{{ 'img/web/pricing/icons/Net-banking.svg' }}"></div> <div class="text-center"> Net Banking </div>
        </a>
    </li>
    <li class="nav-item ">
        <a href="#upi" data-toggle="tab" class="nav-link fee-payment-link p-3 ">
            <div class="text-center"><img src="{{ 'img/web/pricing/icons/UPI.svg' }}"></div> <div class="text-center"> UPI </div>
        </a>
    </li>
    <li class="nav-item ">
        <a href="#wallet" data-toggle="tab" class="nav-link fee-payment-link p-3 ">
            <div class="text-center"><img src="{{ 'img/web/pricing/icons/Wallet.svg' }}"></div> <div class="text-center"> Wallets </div>
        </a>
    </li>
</div>

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
            <img src="{{ asset('img/web/pricing/wallets.png') }}">
        </div>
    </div>

</div>

<style lang="scss" scoped>
    .fee-payment-link {
        background-color: #f7f7f7;
        color: black;
        border: 1px solid #e7e7e7;
    }

    .active {
      background-color: white;
    }

    .image-wrapper img{
      width: 100%;
    }
</style>