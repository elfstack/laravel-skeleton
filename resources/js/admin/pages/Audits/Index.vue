<template>
    <div>
        <a-page-header title="Action Log">
        </a-page-header>
        <listing
            :api="api"
            :columns="columns"
            :binding="{
                        actionColour: actionColour
                    }"
            inline-template>
            <div>
                <a-card :bordered="false">
                    <div>
                        <a-form-model>
                            <a-row>
                                <a-col :span="12">
                                    <a-form-model-item label="Range">
                                        <a-range-picker
                                            :show-time="{ format: 'HH:mm' }"
                                            format="YYYY-MM-DD HH:mm"
                                            :placeholder="['Start Time', 'End Time']"
                                            @change=""
                                            @ok="onOk"
                                        />
                                    </a-form-model-item>
                                </a-col>

                                <a-col :span="12">
                                    <a-form-model-item label="User">
                                        <a-input></a-input>
                                    </a-form-model-item>
                                </a-col>
                            </a-row>

                            <a-form-model-item label="Type">
                                <a-tag color="green">Created</a-tag>
                                <a-tag color="blue">Updated</a-tag>
                                <a-tag color="red">Deleted</a-tag>
                            </a-form-model-item>
                        </a-form-model>
                    </div>
                </a-card>
                <div class="p3">
                    <a-card>
                        <a-table
                            @change="handleChange"
                            :pagination="pagination"
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
                                <a-tag :color="binding['actionColour'][text]">{{ text }}</a-tag>
                            </template>

                        </a-table>
                    </a-card>
                </div>
            </div>
        </listing>
    </div>
</template>

<script>
    import listing from "../../../common/listing";
    import audit from "../../../api/admin/audit";

    export default {
        name: "Index",
        components: {
            listing
        },
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
                    created: 'green',
                    updated: 'blue',
                    deleted: 'red'
                }
            }
        }
    }
</script>

<style scoped>

</style>
