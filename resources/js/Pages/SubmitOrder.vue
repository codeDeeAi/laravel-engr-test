<template>
    <GuestLayout>

        <Head title="Submit Order" />

        <div class="card-header text-xl font-bold mb-6">Submit An Order</div>

        <div class="card-body space-y-6">

            <!-- Basic Details -->
            <div class="grid gap-6">

                <!-- Hmo Code -->
                <div class="gap-2">
                    <InputLabel value="HMO code" />
                    <TextInput class="w-full" type="text" v-model="formData.hmo_code" />
                    <InputError />
                </div>
                <!-- Hmo Code -->

                <!-- Provider Name -->
                <div class="gap-2">
                    <InputLabel value="Provider Name" />
                    <TextInput class="w-full" type="text" v-model="formData.provider" />
                    <InputError />
                </div>
                <!-- Provider Name -->

                <!-- Date -->
                <div class="gap-2">
                    <InputLabel value="Encounter Date" />
                    <TextInput class="w-full" type="date" v-model="formData.encounter_date" />
                    <InputError />
                </div>
                <!-- Date -->

                <!-- Add Items -->
                <div class="flex flex-row-reverse justify-between">

                    <span
                        class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full my-auto">{{
                            formData.items.length || 0 }}
                        items</span>

                    <PrimaryButton @click="addNewItem">
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
                            </td>
                            <td class="px-2 py-4">
                                <TextInput class="w-full" type="number" v-model="item.unit_price" />
                            </td>
                            <td class="px-2 py-4">
                                <TextInput class="w-full" type="number" v-model="item.quantity" />
                            </td>
                            <td class="px-2 py-4">
                                <TextInput class="w-full" readonly type="number" v-model="item.sub_total" />
                            </td>
                            <td class="px-2 py-4">
                                <DangerButton @click="removeItem(index)" class="!px-2">
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
                <PrimaryButton class="my-auto">
                    <div class="flex justify-center gap-2 align-middle py-1 px-3">

                        <span>Submit</span>
                    </div>
                </PrimaryButton>
                <!-- Submit End -->
                <div class="flex align-middle gap-4">
                    <InputLabel value="Total" class="my-auto font-bold text-lg" />
                    <TextInput class="" type="number" readonly v-model="formData.total_items_cost" />
                </div>
            </div>
            <!-- Totals End -->
        </div>
    </GuestLayout>
</template>

<script setup>
import { ref, watch } from "vue";
import { Head } from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import DangerButton from "@/Components/DangerButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const formData = ref({
    hmo_code: "",
    provider: "",
    encounter_date: "",
    total_items_cost: 0,
    items: []
});

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

watch(formData.value.items, () => {

    let total = 0;

    formData.value.items.forEach(item => {
        item.sub_total = parseFloat(item.unit_price * item.quantity) || 0;

        total += item.sub_total;
    });

    formData.value.total_items_cost = total;

}, { deep: true })
</script>
