<template>
    <div>
        <a-page-header title="Manage Storage"></a-page-header>
        <div class="p2">
            <a-row :gutter="[16, 16]">
                <a-col :span="12">
                    <a-card>
                        <a-statistic
                            title="Space Used"
                            :value="diskUsage.used / diskUsage.total * 100"
                            :precision="2"
                            suffix="%"
                            class="demo-class"
                            :value-style="{ color: '#cf1322' }"
                        >
                        </a-statistic>
                    </a-card>
                </a-col>
                <a-col :span="12">
                </a-col>
            </a-row>

            <a-row :gutter="[16, 16]">
                <a-col>
                    <a-card title="Collections">
                        <a-list :data-source="collections" :loading="loading">
                            <a-list-item slot="renderItem" slot-scope="item, index">
                                {{ item.name }}
                            </a-list-item>
                        </a-list>
                    </a-card>
                </a-col>
            </a-row>
        </div>
    </div>
</template>

<script>
    import file from "../../../api/admin/file"

    export default {
        name: "Storage",
        metaInfo: {
            title: 'Manage Storage'
        },
        data() {
            return {
                loading: true,
                diskUsage: {},
                collections: []
            }
        },
        beforeRouteEnter(to, from, next) {
            next(vm => vm.getDiskUsage())
        },
        mounted () {
            this.getCollections()
        },
        methods: {
            getDiskUsage () {
                file.getDiskUsage().then(({data}) => {
                    this.loading = false
                    this.diskUsage = {
                        used: data.disk_total_space - data.disk_free_space,
                        total: data.disk_total_space
                    }
                })
            },
            getCollections () {
                file.getCollections().then(({data}) => {
                    this.collections = data.collections
                })
            }
        }
    }
</script>

<style scoped>

</style>
