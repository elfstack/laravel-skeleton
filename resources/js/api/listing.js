import {isEmptyObject} from "ant-design-vue/lib/vc-form/src/utils";

export default function index ({ pagination, filters, sorter, keyword }, api, modifier=null) {
    const query = {}
    if (sorter.field) {
        query.orderBy = sorter.field
        query.direction = sorter.order === 'descend' ? 'desc' : 'asc'
    }

    if (pagination.current) {
        query.page = pagination.current
    }

    if (pagination.pageSize) {
        query.perPage = pagination.pageSize
    }

    if (keyword) {
        query.keyword = keyword
    }

    if (!isEmptyObject(filters)) {
        let filterQuery = []
        for (const column in filters) {
            filterQuery.push(`${column}:${filters[column].join(',')}`)
        }
        query.filter = filterQuery.join(';')
    }

    if (modifier) {
        modifier(query)
    }

    return window.axios.get(api, { params: query });
}
