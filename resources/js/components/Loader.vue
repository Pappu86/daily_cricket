<template>
    <div id="load-more" class="text-center">
        <button type="button" class="btn btn-primary" @click="customChange">
            Load more +
        </button>
    </div>
</template>

<script>
export default {
    props: ["dataLimit"],
    data() {
        let propsData = this.$props;
        return {
            limit:
                propsData && propsData.dataLimit ? propsData.dataLimit : "10",
            prevLimit: "",
        };
    },
    methods: {
        customChange: function () {
            let instance = this,
                newLimit = instance.limit + 10;

            if (instance.prevLimit) {
                newLimit = instance.prevLimit + 10;
                instance.prevLimit = newLimit;
            } else {
                instance.prevLimit = newLimit;
            }
            this.$emit("hendleLoadMore", instance, newLimit);
        },
    },
};
</script>
