<template>
    <a-result status="403" title="403" sub-title="Sorry, you are not authorized to access this page.">
        <template #extra>
            <router-link to="/">
                <a-button type="primary">
                    Back Home
                </a-button>
            </router-link>
        </template>
    </a-result>
</template>
<script>
    export default {
        metaInfo: {
            title: '403'
        }
    };
</script>
