<template>
    <div>
        <a-page-header title="Action Log">
        </a-page-header>
        <a-card :bordered="false">
            <div>
                <a-form-model layout="inline">
                    <a-row>
                        <a-col :span="12">
                            <a-form-model-item label="Range">
                                <a-range-picker
                                    :show-time="{ format: 'HH:mm' }"
                                    format="YYYY-MM-DD HH:mm"
                                    :placeholder="['Start Time', 'End Time']"
                                    @ok="filterRange"
                                />
                            </a-form-model-item>
                        </a-col>

                        <a-col :span="12">
                            <a-form-model-item label="Type">
                                <a-tag
                                    :key="type"
                                    v-for="type in Object.keys(actionColour)"
                                    :color="actionColour[type]"
                                    @click="filterTag('event', [type])"
                                >
                                    {{ type }}
                                </a-tag>
                            </a-form-model-item>
                        </a-col>
                    </a-row>

                </a-form-model>
            </div>
        </a-card>
        <div class="p2">
            <a-card>
                <a-table
                    @change="handleChange"
                    :pagination="listing.pagination"
                    :loading="loading"
                    :columns="columns"
                    row-key="id"
                    :data-source="data"
                >
                    <template slot="time" slot-scope="text">
                        {{ text | moment('YYYY-MM-DD HH:mm:ss')}}
                    </template>
                    <template slot="on" slot-scope="text">
                        <a-tag color="blue">{{ text }}</a-tag>
                    </template>

                    <template #event="text">
                        <a-tag :color="actionColour[text]">{{ text }}</a-tag>
                    </template>

                </a-table>
            </a-card>
        </div>
    </div>
</template>

<script>
    import listing from "../../../common/mixins/listing";
    import audit from "../../../api/admin/audit";

    export default {
        name: "Index",
        mixins: [listing],
        data() {
            return {
                api: audit.index,
                columns: [
                    {dataIndex: 'event', key: 'event', title: 'Type', scopedSlots: {customRender: 'event'}},
                    {
                        dataIndex: 'created_at',
                        key: 'created_at',
                        title: 'Time',
                        sorter: true,
                        scopedSlots: {customRender: 'time'}
                    },
                    {
                        dataIndex: 'auditable_type',
                        key: 'auditable_type',
                        title: 'On',
                        scopedSlots: {customRender: 'on'}
                    },
                    {dataIndex: 'user.name', key: 'user.id', title: 'User', scopedSlots: {customerRender: 'user '}},
                    {dataIndex: 'description', key: 'description', title: 'Description'},
                ],
                actionColour: {
                    all: 'cyan',
                    created: 'green',
                    updated: 'blue',
                    deleted: 'red'
                }
            }
        },
        methods: {
            filterRange (dates) {
                this.listing.range = {
                    from: dates[0],
                    to: dates[1]
                }
                this.fetchData()
            },
            filterTag (column, values) {
                if (values.includes('all')) {
                    this.clearFilter(column)
                    return
                }

                this.filter(column, values)
            }
        }
    }
</script>

<style scoped>

</style>
