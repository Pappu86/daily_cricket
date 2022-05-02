<template>
    <div class="container">
        <div class="row justify-content-md-center access-token-container">
            <div class="col col-lg-4 col-sm-12">
                <input
                    class="form-control me-2"
                    type="text"
                    v-model="accessToken"
                    placeholder="Enter your access token.."
                />
                <small id="error" class="error-msg">
                    Please enter your valid access token.
                </small>
            </div>
            <div class="col-lg-3 col-sm-12 token-btn-container">
                <button class="btn btn-outline-primary" @click="saveToken">
                    Save token
                </button>
                <button
                    class="btn btn-outline-secondary ml-10"
                    @click="resetToken"
                >
                    Reset token
                </button>
            </div>
        </div>
        <!-- <div class="d-flex access-token-container">
            <input
                class="form-control me-2"
                type="text"
                v-model="accessToken"
                placeholder="Enter your access token.."
            />
            <button
                class="btn btn-outline-primary btn-token"
                @click="saveToken"
            >
                Save token
            </button>
            <button
                class="btn btn-outline-secondary btn-token ml-10"
                @click="resetToken"
            >
                Reset token
            </button>
        </div> -->
        <!-- <small id="error" class="error-msg">
            Please enter your valid access token.
        </small> -->
    </div>
</template>

<script>
import { showLoader, hideLoader } from "../generalHelpers";

export default {
    data() {
        return {
            accessToken: !!localStorage.getItem("accessToken")
                ? localStorage.getItem("accessToken")
                : "",
        };
    },
    methods: {
        saveToken: function (event) {
            let instance = this,
                token = instance.accessToken,
                isValidToken = false;

            if (token) {
                let apiUrl =
                    "https://rest.entitysport.com/v2/matches?token=" + token;

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: apiUrl,
                    success: function (data) {
                        if (data.status === "ok") {
                            showLoader(false);
                            isValidToken = true;
                            hendleErrorMsg(instance, isValidToken);
                            localStorage.setItem("accessToken", token);
                            window.location.replace("/live-upcoming");
                        }
                    },
                });

                hendleErrorMsg(instance, isValidToken);
            } else {
                hendleErrorMsg(instance, isValidToken);
            }
        },
        resetToken: function (event) {
            let instance = this;
            if (localStorage.getItem("accessToken")) {
                instance.accessToken = "";
                localStorage.setItem("accessToken", "");
            }
        },
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

/**
 * Error message hendle
 *
 * @param string
 * @Result Show/Hide error message
 */
const hendleErrorMsg = (instance, isValidToken) => {
    if (isValidToken) {
        $("#error").css({ display: "none" });
    } else {
        $("#error").css({ display: "flex" });
    }
};
</script>

<style scoped>
.access-token-container {
    margin: 100px auto 0;
}

/* Large devices (desktops, 992px and up) */
@media (max-width: 992px) {
    .token-btn-container {
        text-align: center;
        margin-top: 20px;
    }
}
</style>
