import { Table } from 'antd';
import { router } from '@inertiajs/react';

export default function PaginatedTable({ dataTable, columns }) {

    const { data, meta } = dataTable;
    const links = meta?.links;

    const state = {
        dataSource: data,
        pagination: {
            total: meta.total,
            pageSize: meta.per_page,
            current: meta.current_page,
            showTotal: (total, range) => `${range[0]}-${range[1]} de ${total} Datos`
        },
        filters: {},
        loading: false
    }

    const { pagination, dataSource } = state;

    const handleTableChange = (pagination, filters) => {
        //const pager = { ...state.pagination };
        const { url } = { ...links.find((link) => link.label == pagination.current) };

        //Send data from url 
        router.visit(url, {
            preserveScroll: true
        });

    };

    return (
        <Table
            dataSource={dataSource}
            columns={columns}
            pagination={pagination}
            scroll={{ x: 700 }}
            onChange={handleTableChange}
            loading={state.loading}
        />
    );


}
