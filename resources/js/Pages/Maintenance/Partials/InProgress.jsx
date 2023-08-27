
import { Typography, Tag, Space, Tooltip, Button } from 'antd';
import { EyeOutlined } from '@ant-design/icons';
import { usePage, router, Link } from '@inertiajs/react';
import PaginatedTable from '@/Components/PaginatedTable';
import collectionColors from '/resources/js/Providers/ColorProvider.js'

const { colorStatus } = collectionColors;
const { Title } = Typography;


const InProgress = ({ progressData }) => {

    const columns = [
        {
            title: 'Estatus',
            key: 'status',
            dataIndex: 'status',
            with: '10%',
            render: (_, { status }) => {
                let color;
                color = colorStatus[status.toUpperCase()] || 'blue'
                return (
                    <Tag color={color}>
                        {status.toUpperCase()}
                    </Tag>
                );
            },
        },
        {
            title: 'Placa',
            dataIndex: 'plate',
            key: 'plate',
            width: '10%',
        },
        {
            title: 'Chassis',
            dataIndex: 'chassis',
            key: 'chassis',
            width: '10%',
        },
        {
            title: 'Kilometraje',
            dataIndex: 'mileage',
            key: 'mileage',
            width: '20%'
        },
        {
            title: 'Fecha de Mantenimiento',
            dataIndex: 'shift_date',
            key: 'shift_date',
            width: '20%'
        },
        {
            title: 'Horario de Mantenimiento',
            dataIndex: 'shift_time_range',
            key: 'shift_time_range',
            width: '20%'
        },
        {
            title: 'Identificación',
            dataIndex: 'identification',
            key: 'identification',
            width: '20%'
        },
        {
            title: 'Acciones',
            key: 'action',
            align: 'center',
            width: '15%',
            render: (_, record) => (
                <>
                    <Space size="small">
                        {
                            <>
                                <Link href={route('maintenance.show', record.key)}>
                                    <Tooltip title={'Ver más'}>
                                        <Button shape='round'  icon={<EyeOutlined />} />
                                    </Tooltip>
                                </Link>
                            </>
                        }

                    </Space>
                </>
            ),
        },
    ];


    return (
        <>
            <div className="flex items-center mt-2 mb-4">
                <Title level={2} ellipsis>
                    Mantenimiento en curso
                </Title>
                <h1 className="flex-1 border-b-2 border-gray-100"></h1>
            </div>

            <PaginatedTable
                columns={columns}
                dataTable={progressData}
            ></PaginatedTable>
        </>
    );
}

export default InProgress;