<script setup>
import { FwbHeading, FwbInput, FwbButton } from "flowbite-vue";
import { reactive, ref } from "vue";
import Loader from "../components/Loader.vue";
import { useToast } from "vue-toast-notification";
import { useRouter } from "vue-router";

const router = useRouter();

const data = reactive({
    name: "",
    email: "",
    mobile: "",
    nid: "",
    address: "",
});

const errors = reactive({
    name: "",
    email: "",
    mobile: "",
    nid: "",
    address: "",
});

const isLoading = ref(false);

const $toast = useToast();

const resetErrors = () => {
    errors.name = "";
    errors.email = "";
    errors.mobile = "";
    errors.nid = "";
    errors.address = "";
};

const updateErrors = (formErrors) => {
    errors.name = formErrors.name?.[0] ?? "";
    errors.email = formErrors.email?.[0] ?? "";
    errors.mobile = formErrors.mobile?.[0] ?? "";
    errors.nid = formErrors.nid?.[0] ?? "";
    errors.address = formErrors.address?.[0] ?? "";
};

const onSubmit = () => {
    resetErrors();
    isLoading.value = true;
    axios
        .post("api/users", data)
        .then((response) => {
            $toast.success(response.data.message);
            router.push({ name: "home" });
        })
        .catch((error) => {
            if (error.response?.data?.errors) {
                updateErrors(error.response.data.errors);
            }

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
        <fwb-heading tag="h4">Registration Form</fwb-heading>

        <form @submit.prevent="onSubmit">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-8">
                <fwb-input
                    v-model="data.name"
                    placeholder="Full name"
                    label="Full name"
                    :validation-status="`${errors.name ? 'error' : ''}`"
                >
                    <template #validationMessage>
                        {{ errors.name }}
                    </template>
                </fwb-input>

                <fwb-input
                    v-model="data.email"
                    placeholder="Email address"
                    label="Email address"
                    type="email"
                    :validation-status="`${errors.email ? 'error' : ''}`"
                >
                    <template #validationMessage>
                        {{ errors.email }}
                    </template>
                </fwb-input>

                <fwb-input
                    v-model="data.mobile"
                    placeholder="Mobile number"
                    label="Mobile number"
                    :validation-status="`${errors.mobile ? 'error' : ''}`"
                >
                    <template #validationMessage>
                        {{ errors.mobile }}
                    </template>
                </fwb-input>

                <fwb-input
                    v-model="data.nid"
                    placeholder="NID card number"
                    label="NID card number"
                    :validation-status="`${errors.nid ? 'error' : ''}`"
                >
                    <template #validationMessage>
                        {{ errors.nid }}
                    </template>
                </fwb-input>

                <div class="sm:col-span-2">
                    <fwb-input
                        v-model="data.address"
                        label="Address"
                        placeholder="Address"
                        :validation-status="`${errors.address ? 'error' : ''}`"
                        ><template #validationMessage>
                            {{ errors.address }}
                        </template>
                    </fwb-input>
                </div>

                <div class="sm:col-span-2">
                    <fwb-button type="submit"> Submit </fwb-button>
                </div>
            </div>
        </form>
    </div>
</template>
