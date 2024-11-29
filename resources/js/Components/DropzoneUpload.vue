<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import { ArrowDownTrayIcon, ArrowPathIcon } from "@heroicons/vue/24/outline";
import InputError from "./InputError.vue";

const props = defineProps({
    uploadUrl: String,
});

const dragover = ref(false);
const inputFile = ref(null);
const form = useForm({
    files: [],
});

const uploadClickedFiles = (event) => {
    form.files = event.target.files;
    uploadFiles();
};

const uploadDroppedFiles = (event) => {
    form.files = event.dataTransfer.files;
    uploadFiles();
};

const uploadFiles = () => {
    form.post(props.uploadUrl, {
        onSuccess: () => {
            form.files = [];
            inputFile.value.value = null;
        },
        preserveScroll: true,
        onError: (errors) => {
            const filesErrors = Object.keys(errors).filter((key) =>
                key.startsWith("files")
            );
            form.errors.files = filesErrors.map((key) => errors[key]);
        },
        onFinish: () => {
            dragover.value = false;
        },
    });
};
</script>

<template>
    <input
        ref="inputFile"
        class="hidden"
        type="file"
        multiple
        @change="uploadClickedFiles"
    />
    <div
        id="dropzone"
        @click="inputFile.click()"
        @dragover.prevent="dragover = true"
        @dragleave.prevent="dragover = false"
        @drop.prevent="uploadDroppedFiles"
        class="flex items-center justify-center cursor-pointer rounded-lg bg-gray-100 p-8 border-2 border-dashed border-indigo-300 hover:bg-indigo-50"
        :class="{ 'bg-indigo-50': dragover }"
    >
        <div
            v-if="form.processing"
            class="flex flex-col items-center justify-center space-y-4"
        >
            <div>
                <ArrowPathIcon class="w-6 h-6 text-indigo-400 animate-spin" />
            </div>
            <progress
                v-if="form.progress"
                :value="form.progress.percentage"
                max="100"
            ></progress>
            <div>{{ form.progress.percentage }}%</div>
        </div>
        <div v-else>
            <ArrowDownTrayIcon class="w-12 h-12 text-indigo-400" />
        </div>
    </div>
    <InputError
        v-for="error in form.errors.files"
        :key="error"
        :message="error"
    />
</template>
