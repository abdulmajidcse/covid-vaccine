<script setup>
import { FwbHeading, FwbInput, FwbButton, FwbSelect } from "flowbite-vue";
import { reactive, ref, onMounted } from "vue";
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
    vaccine_center_id: "",
});

const errors = reactive({
    name: "",
    email: "",
    mobile: "",
    nid: "",
    address: "",
    vaccine_center_id: "",
});

const isLoading = ref(false);

const vaccineCenters = ref([]);

const $toast = useToast();

const resetErrors = () => {
    errors.name = "";
    errors.email = "";
    errors.mobile = "";
    errors.nid = "";
    errors.address = "";
    errors.vaccine_center_id = "";
};

const updateErrors = (formErrors) => {
    errors.name = formErrors.name?.[0] ?? "";
    errors.email = formErrors.email?.[0] ?? "";
    errors.mobile = formErrors.mobile?.[0] ?? "";
    errors.nid = formErrors.nid?.[0] ?? "";
    errors.address = formErrors.address?.[0] ?? "";
    errors.vaccine_center_id = formErrors.vaccine_center_id?.[0] ?? "";
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

const getVaccineCenters = () => {
    isLoading.value = true;
    axios
        .get("api/vaccine-centers")
        .then((response) => {
            vaccineCenters.value = response.data.data;
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

onMounted(() => {
    getVaccineCenters();
});
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

                <fwb-select
                    v-model="data.vaccine_center_id"
                    :options="vaccineCenters"
                    label="Vaccine center"
                    :validation-status="`${
                        errors.vaccine_center_id ? 'error' : ''
                    }`"
                >
                    <template #validationMessage>
                        {{ errors.vaccine_center_id }}
                    </template>
                </fwb-select>

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
