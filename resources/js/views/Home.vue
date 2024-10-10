<script setup>
import { FwbHeading, FwbAlert } from "flowbite-vue";
</script>

<template>
    <div class="mx-auto">
        <fwb-heading tag="h2">Get your COVID-19 Vaccine</fwb-heading>

        <div class="vp-raw grid gap-2 mt-8">
            <fwb-alert class="border-t-4 rounded-none" icon type="info">
                <div>
                    Firstly, complete your
                    <router-link
                        :to="{ name: 'register' }"
                        class="underline hover:no-underline font-semibold"
                        >registration</router-link
                    >.
                </div>
            </fwb-alert>
            <fwb-alert class="border-t-4 rounded-none" icon type="danger">
                Secondly, you'll get an email with a date to book your vaccine.
            </fwb-alert>
            <fwb-alert class="border-t-4 rounded-none" icon type="success">
                Finally, go to the vaccination center and get your vaccine.
            </fwb-alert>
        </div>
    </div>
</template>
