<template>
    <GuestLayout>

        <Head title="Submit Order" />

        <div class="card-header text-xl font-bold mb-6">Submit An Order</div>

        <div class="card-body space-y-6">

            <!-- Alerts -->
            <!-- Error -->
            <div id="alert-2" v-show="errors['main']"
                class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                role="alert">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div class="ms-3 text-sm font-medium">
                   {{ errors['main'] }}
                </div>
                <button type="button" @click="clearSpecificError('main')"
                    class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"
                    data-dismiss-target="#alert-2" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
            <!-- Error Ends -->

            <!-- Success -->
            <div id="alert-3" v-show="successMsg"
                class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                role="alert">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div class="ms-3 text-sm font-medium">
                    {{ successMsg }}
                </div>
                <button type="button" @click="successMsg = ''"
                    class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                    data-dismiss-target="#alert-3" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
            <!-- Success Ends -->
            <!-- Alerts End -->

            <!-- Basic Details -->
            <div class="grid gap-6">

                <!-- Hmo Code -->
                <div class="gap-2">
                    <InputLabel value="HMO code" />
                    <TextInput class="w-full" type="text" v-model="formData.hmo_code" />
                    <!-- Suggestions -->
                    <small v-show="hmoSuggestions.length > 0" class="flex gap-2 my-1 ">
                        <span>Available HMO's are:</span>
                        <span v-for="(sug, index) in hmoSuggestions" :key="index"
                            class="font-semibold text-green-300">{{ sug.code }},
                        </span>
                        <button type="button" class="underline ml-2" @click="clearSuggestions">clear
                            suggestions</button>
                    </small>
                    <!-- Suggestions End -->
                    <InputError v-show="errors['hmo_code']" :message="errors['hmo_code']" />
                </div>
                <!-- Hmo Code -->

                <!-- Provider Name -->
                <div class="gap-2">
                    <InputLabel value="Provider Name" />
                    <TextInput class="w-full" type="text" v-model="formData.provider" />
                    <InputError v-show="errors['provider']" :message="errors['provider']" />
                </div>
                <!-- Provider Name -->

                <!-- Date -->
                <div class="gap-2">
                    <InputLabel value="Encounter Date" />
                    <TextInput class="w-full" type="date" v-model="formData.encounter_date" />
                    <InputError v-show="errors['encounter_date']" :message="errors['encounter_date']" />
                </div>
                <!-- Date -->

                <!-- Add Items -->
                <div class="flex flex-row-reverse justify-between">

                    <span
                        class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full my-auto">{{
                            formData.items.length || 0 }}
                        items</span>

                    <PrimaryButton @click="addNewItem" :disabled="isLoading">
                        <div class="flex justify-center gap-2 align-middle">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>

                            <span>Add Item</span>
                        </div>
                    </PrimaryButton>

                </div>
                <!-- Add Items -->

            </div>
            <!-- Basic Ends -->

            <!-- Table -->
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                        <tr>
                            <th scope="col" colspan="4" class="px-2 py-3">
                                Item
                            </th>
                            <th scope="col" class="px-2 py-3">
                                Unit Price
                            </th>
                            <th scope="col" class="px-2 py-3">
                                Qty
                            </th>
                            <th scope="col" class="px-2 py-3">
                                Subtotal
                            </th>
                            <th scope="col" class="px-2 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody v-for="(item, index) in formData.items" :key="index">
                        <tr class="odd:bg-white even:bg-gray-50  border-b ">
                            <td colspan="4" class="px-2 py-4">
                                <TextInput class="w-full" type="text" v-model="item.name" />

                                <InputError v-show="errors[`items.${index}.name`]"
                                    :message="errors[`items.${index}.name`]" />

                            </td>
                            <td class="px-2 py-4">
                                <TextInput class="w-full" type="number" v-model="item.unit_price" />

                                <InputError v-show="errors[`items.${index}.unit_price`]"
                                    :message="errors[`items.${index}.unit_price`]" />
                            </td>
                            <td class="px-2 py-4">
                                <TextInput class="w-full" type="number" v-model="item.quantity" />

                                <InputError v-show="errors[`items.${index}.quantity`]"
                                    :message="errors[`items.${index}.quantity`]" />
                            </td>
                            <td class="px-2 py-4">
                                <TextInput class="w-full" readonly type="number" v-model="item.sub_total" />

                                <InputError v-show="errors[`items.${index}.sub_total`]"
                                    :message="errors[`items.${index}.sub_total`]" />
                            </td>
                            <td class="px-2 py-4">
                                <DangerButton @click="removeItem(index)" class="!px-2" :disabled="isLoading">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Table Ends -->

            <!-- Totals -->
            <div class="flex justify-between gap-4 align-middle">
                <!-- Submit -->
                <PrimaryButton class="my-auto flex align-middle gap-3" @click="submitForm" :disabled="isLoading">
                    <div class="flex justify-center gap-2 align-middle py-1 px-3">
                        <span v-if="!isLoading">Submit</span>
                        <div v-else role="status" class="flex gap-3 ">
                            <svg aria-hidden="true" class="inline size-4 text-gray-200 animate-spin"
                                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                    fill="currentColor" />
                                <path
                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                    fill="currentFill" />
                            </svg>
                            <span class="">Loading...</span>
                        </div>
                    </div>
                </PrimaryButton>
                <!-- Submit End -->
                <div class="flex align-middle gap-4">
                    <InputLabel value="Total" class="my-auto font-bold text-lg" />
                    <TextInput class="" type="number" readonly v-model="formData.total_items_cost" />
                    <InputError v-show="errors[`total_items_cost`]" :message="errors[`total_items_cost`]" />
                </div>
            </div>
            <!-- Totals End -->
        </div>
    </GuestLayout>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import { ref, watch, computed } from "vue";
import { useDebounceFn } from '@vueuse/core';
import TextInput from "@/Components/TextInput.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import DangerButton from "@/Components/DangerButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const baseUrl = '/api/v1';

const hmoSuggestions = ref([]);

const formData = ref({
    hmo_code: "",
    provider: "",
    encounter_date: "",
    total_items_cost: 0,
    items: []
});

const isLoading = ref(false);

const errors = ref({});

const successMsg = ref("");

// Clear HMO suggestions
const clearSuggestions = () => {
    hmoSuggestions.value = [];
};

// Add new item 
const addNewItem = () => {
    const template = {
        name: "",
        unit_price: 0,
        quantity: 1,
        sub_total: 0
    };

    formData.value.items.push(template);
};

// Remove item
const removeItem = (index) => {
    formData.value.items.splice(index, 1);
};

// Get HMO autosuggestion
const getHmoAutoSuggestion = async (search) => {
    try {
        const res = await fetch(`${baseUrl}/hmo/suggestions?search=${search}`);

        if (!res.ok)
            throw new Error(`Failed to fetch HMO suggestions: ${res.status}`);

        const { result } = await res.json();


        hmoSuggestions.value = result;

    } catch (error) {
        console.error('Error fetching HMO suggestions:', error);
    }
}

// Format Date. This returns date in this format: // YYYY-MM-DD format
const formatDate = (input_date) => {
    const selectedDate = new Date(input_date);
    return selectedDate.toISOString().slice(0, 10);
};

// Submit Form
const submitForm = async () => {

    if (!validateForm.value) return;

    isLoading.value = true;

    try {

        const { hmo_code, provider, encounter_date, total_items_cost, items } = formData.value

        const data_to_submit = {
            hmo_code,
            encounter_date: formatDate(encounter_date),
            provider,
            total_items_cost,
            items,
        }

        const res = await fetch(`${baseUrl}/order`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json'
            },
            body: JSON.stringify(data_to_submit)
        });

        isLoading.value = false;

        if (!res.ok) {

            if (res.status === 422) {

                const { errors, message } = await res.json();

                for (const key in errors) {
                    if (Object.prototype.hasOwnProperty.call(errors, key)) {
                        const errorBag = errors[key];

                        addSpecificError(key, errorBag[0]);
                    }
                }

                throw new Error(message || `Failed to create order`);
            }

            throw new Error(`Failed to create order`);
        }

        const { result: data } = await res.json(); // Just in case we need the response data

        // Alert Success
        successMsg.value = `Order created successfully with ID: ${data.id}`

        // Clear Errors
        clearErrors();

        // Reset form
        resetForm();

    } catch (error) {

        isLoading.value = false;

        addSpecificError('main', error?.message)

        console.error('Error creating order:', error?.message);


    }
}

// Reset Form
const resetForm = () => {
    formData.value = {
        hmo_code: "",
        provider: "",
        encounter_date: "",
        total_items_cost: 0,
        items: []
    }
}

// Clear Errors
const clearErrors = () => errors.value = {};

// Clear Specific Error
const clearSpecificError = (key) => errors.value[key] = "";

// Add Specific Error
const addSpecificError = (key, msg) => errors.value[key] = msg;

const validateForm = computed(() => {

    if (!formData.value.hmo_code) {

        addSpecificError('hmo_code', "HMO Code is required");

        return false;
    }

    clearSpecificError('hmo_code');

    if (!formData.value.provider) {

        addSpecificError('provider', "Provider Name is required");

        return false;
    }

    clearSpecificError('provider');

    if (!formData.value.encounter_date) {

        addSpecificError('encounter_date', "Encounter Date is required");

        return false;
    }

    clearSpecificError('encounter_date');

    for (let index = 0; index < formData.value.items.length; index++) {
        const item = formData.value.items[index];

        if (!item.name) {
            addSpecificError(`items.${index}.name`, "Name is required");

            return false;
        }

        clearSpecificError(`items.${index}.name`);

        if (!item.unit_price || item.unit_price <= 0) {
            addSpecificError(`items.${index}.unit_price`, "Unit price must be greater than 0");

            return false;
        }

        clearSpecificError(`items.${index}.unit_price`);

        if (!item.quantity || item.quantity <= 0) {
            addSpecificError(`items.${index}.quantity`, "Quantity must be greater than 0");

            return false;
        }

        clearSpecificError(`items.${index}.quantity`);

        if (!item.quantity || item.quantity <= 0) {
            addSpecificError(`items.${index}.quantity`, "Quantity must be greater than 0");

            return false;
        }

        clearSpecificError(`items.${index}.quantity`);

    }

    clearErrors();

    return true;
})

watch(() => formData.value.hmo_code,
    () => {
        useDebounceFn(getHmoAutoSuggestion(formData.value.hmo_code), 1000)
    })

watch(formData.value.items, () => {

    let total = 0;

    formData.value.items.forEach(item => {
        item.sub_total = parseFloat(item.unit_price * item.quantity) || 0;

        total += item.sub_total;
    });

    formData.value.total_items_cost = total;

}, { deep: true })
</script>
