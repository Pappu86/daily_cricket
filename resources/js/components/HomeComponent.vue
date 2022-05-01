<template>
    <div>
        <h2>Home page</h2>
    </div>
</template>

<script>
import { showLoader, hideLoader } from "../generalHelpers";

export default {
    data() {
        return {};
    },
    mounted() {
        let instance = this;
        instance.$nextTick(() => {
            setTimeout(() => {
                hideLoader();
            }, 1000);
        });
    },
};
</script>
