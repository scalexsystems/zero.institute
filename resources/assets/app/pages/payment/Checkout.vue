<template>
    <button id="rzp-button1" @click="pay">Pay</button>
</template>

<script lang="babel">
export default {
    data: () => ({
        options: {
            "key": "YOUR_KEY_ID",
            "amount": "2000", // 2000 paise = INR 20
            "name": "Merchant Name",
            "description": "Purchase Description",
            "image": "/your_logo.png",
            "handler": function (response) {
                alert(response.razorpay_payment_id);
            },
            "prefill": {
                "name": "Harshil Mathur",
                "email": "harshil@razorpay.com"
            },
            "notes": {
                "address": "Hello World"
            },
            "theme": {
                "color": "#F37254"
            }
        }
    }),

    computed: {

    },


    methods: {
        pay() {
          const razorpay = new Razorpay(this.options);
          razorpay.open();
        }

    }




};

</script>

<style lang="scss">

</style>
