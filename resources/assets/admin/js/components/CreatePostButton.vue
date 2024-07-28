<template>
    <button
        @click="createNew"
        :class="isloading ? 'btn-loading disabled' : ''"
        :disabled="isloading"
        class="create_new_post"
    >
        <slot></slot>
    </button>
</template>
<script>
import axios from "axios"; 
export default {
    data() {
        return {
            isloading: false,
        };
    },
    methods: {
        createNew() {
            this.isloading = true;
            axios
                .post(route("admin.create.post"))
                .then((res) => {
                    const data = res.data;
                    window.location = route("admin.create.get", {
                        id: data.slug,
                    });
                    this.isloading = false;
                })
                .catch((err) => {
                    console.log(err);
                    this.isloading = false;
                });
        },
    },
};
</script>
