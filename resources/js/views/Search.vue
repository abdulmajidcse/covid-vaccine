<script setup>
import { ref } from "vue";
import { FwbButton, FwbInput, FwbHeading, FwbAlert } from "flowbite-vue";
import Loader from "../components/Loader.vue";

const nid = ref("");
const nid_error = ref("");
const isLoading = ref(false);
const searchResult = ref("");
const resultType = ref("");

const onSubmit = () => {
    if (!nid.value) {
        nid_error.value = "The nid field is required.";
        return false;
    }

    nid_error.value = "";
    searchResult.value = "";
    resultType.value = "";
    isLoading.value = true;
    axios
        .get(`api/search/${nid.value}`)
        .then((response) => {
            searchResult.value = response.data.message;
            resultType.value = response.data.data.result_type;
        })
        .catch((error) => {
            $toast.error(
                error.response?.data?.message ?? "Something went wrong!"
            );
        })
        .finally(() => {
            isLoading.value = false;
        });
};
</script>

<template>
    <div class="min-w-full md:min-w-[600px] lg:min-w-[800px] mx-auto">
        <Loader v-if="isLoading" />
        <fwb-heading tag="h4">Search Schedule</fwb-heading>

        <form @submit.prevent="onSubmit">
            <div class="mt-8">
                <fwb-input
                    v-model="nid"
                    label=""
                    placeholder="NID card number"
                    size="lg"
                    :validation-status="`${nid_error ? 'error' : ''}`"
                >
                    <template #validationMessage>
                        {{ nid_error }}
                    </template>
                    <template #prefix>
                        <svg
                            aria-hidden="true"
                            class="w-5 h-5 text-gray-500 dark:text-gray-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                            />
                        </svg>
                    </template>
                    <template #suffix>
                        <fwb-button type="submit">Search</fwb-button>
                    </template>
                </fwb-input>

                <div class="mt-4" v-if="searchResult">
                    <fwb-alert
                        class="border-t-4 rounded-none"
                        icon
                        :type="resultType ?? 'info'"
                    >
                        <div>
                            {{ searchResult }}.
                            <span v-if="searchResult === 'Not registered'"
                                >Please, complete your
                                <router-link
                                    :to="{ name: 'register' }"
                                    class="underline hover:no-underline font-semibold"
                                    >registration</router-link
                                >.</span
                            >
                        </div>
                    </fwb-alert>
                </div>
            </div>
        </form>
    </div>
</template>
