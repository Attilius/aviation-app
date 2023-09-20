<script setup>
import { onMounted, ref }  from 'vue'
import { loadScript } from "@paypal/paypal-js";

const props = defineProps({
    reference: Object
});

const paypal = ref(null)

onMounted( () => {

    loadScript({ clientId: props.reference.paypalClientId })
        .then((paypal) => {
            paypal
                .Buttons({
                    style: {
                        layout: 'vertical',
                        color:  'blue',
                        shape:  'pill',
                        label:  'pay'
                    },
                    createOrder() {
                        return fetch(route('handle-payment'), {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                            },
                            body: JSON.stringify({
                                cart: [
                                    {
                                        sku: "YOUR_PRODUCT_STOCK_KEEPING_UNIT",
                                        quantity: "YOUR_PRODUCT_QUANTITY",
                                    },
                                ]
                            })
                        })
                            .then((response) => response.json())
                            .then((order) => order.id);
                    }
                })
                .render("#paypal-button-container")
                .catch((error) => {
                    console.error("failed to render the PayPal Buttons", error);
                });
        })
        .catch((error) => {
            console.error("failed to load the PayPal JS SDK script", error);
        });
    });

</script>

<template>
    <div id="paypal-button-container"
         class="w-1/3 flex items-center z-0"
         ref="paypal"
    >
    </div>
</template>

