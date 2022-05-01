<template>
    <div class="container">
        <div class="d-flex access-token-container">
            <input
                class="form-control me-2"
                type="text"
                placeholder="Enter your access token.."
            />
            <button class="btn btn-outline-primary btn-token">
                Save token
            </button>
        </div>
        <small class="error-msg"> Please enter your valid access token. </small>
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
