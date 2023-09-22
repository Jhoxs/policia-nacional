
import { Typography, Tag, Space, Tooltip, Button, Popconfirm, Input } from 'antd';
import { EyeOutlined, CheckOutlined, CloseOutlined, QuestionCircleOutlined } from '@ant-design/icons';
import { usePage, router, Link } from '@inertiajs/react';
import PaginatedTable from '@/Components/PaginatedTable';
import collectionColors from '/resources/js/Providers/ColorProvider.js';
import { useState } from 'react';

const { colorStatus } = collectionColors;
const { Title, Text } = Typography;


const InProgress = ({ progressData }) => {

    const { permissions } = usePage().props?.auth || [];
    const isManager = permissions.includes('maintenance.manager');

    const [rejectedReason, setRejectedReason] = useState('');
    const confirm = data => e => {

        const info = {
            idMaintenance: data,
            reasonReject: rejectedReason,
            typeRequest: 'reject'
        }

        router.post(route('requestmorder.store', info), {
            onSuccess: () => {
                message.success('Se aceptó la solicitud de este usuario');
            }
        });
    }

    const cancel = () => {
        //message.warning('Se canceló esa acción');
    }

    const acceptMaintenance = data => e => {
        const info = {
            idMaintenance: data,
            reasonReject: '',
            typeRequest: 'accept'
        }
        router.post(route('requestmorder.store', info), {
            onSuccess: () => {
                message.success('Se denegó la solicitud de este usuario');
            }
        });
    }



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
            title: 'Motivo',
            dataIndex: 'reason',
            key: 'reason',
            width: '10%',
        },
        {
            title: 'Kilometraje',
            dataIndex: 'mileage',
            key: 'mileage',
            width: '20%'
        },
        {
            title: 'Fecha de Orden',
            dataIndex: 'departure_date',
            key: 'departure_date',
            width: '20%'
        },
        {
            title: 'Horario de Orden',
            dataIndex: 'departure_time',
            key: 'departure_time',
            width: '20%'
        },
        {
            title: 'Identificación Responsable',
            dataIndex: 'identification',
            key: 'identification',
            width: '20%'
        },
        {
            title: 'Identificación Conductor',
            dataIndex: 'identification_driver',
            key: 'identification_driver',
            width: '20%'
        },
        {
            title: 'Identificación Pasajeros',
            dataIndex: 'identification_pass',
            key: 'identification_pass',
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
                        { false &&
                            (<>
                                <Link href={route('maintenance.show', record.key)}>
                                    <Tooltip title={'Ver más'}>
                                        <Button shape='round' icon={<EyeOutlined />} />
                                    </Tooltip>
                                </Link>
                            </>)
                        }
                        {isManager && (record.status == 0 || record.status == 'SOLICITUD ENVIADA' ) && (
                            <>
                                <Tooltip title={'Aceptar Solicitud'}>
                                    <Button
                                        size='middle'
                                        shape='round'
                                        className="bg-[#52c41a]"
                                        type='primary'
                                        icon={<CheckOutlined />}
                                        onClick={acceptMaintenance(record.key)}
                                    />
                                </Tooltip>

                                <Tooltip title={'Rechazar Solicitud'}>
                                    <Popconfirm
                                        title='Rechazar Solicitud'
                                        description={<>
                                            <Text>
                                                ¿Está seguro que desea rechazar esta solicitud?
                                            </Text>
                                            <Input.TextArea
                                                placeholder='Escriba el motivo...'
                                                className='mt-3 mb-3'
                                                maxLength={255}
                                                value={rejectedReason}
                                                onChange={e => setRejectedReason(e.target.value)}
                                            />
                                        </>}
                                        okText='Si'
                                        cancelText='No'
                                        icon={<QuestionCircleOutlined style={{ color: 'red' }} />}
                                        okButtonProps={{ danger: true, size: 'middle' }}
                                        cancelButtonProps={{ size: 'middle' }}
                                        onConfirm={confirm(record.key)}
                                        onCancel={cancel}
                                        onClick={() => setRejectedReason('')}
                                    >
                                        <Button
                                            size='middle'
                                            type="primary"
                                            danger
                                            shape='round'
                                            icon={<CloseOutlined />}
                                        />
                                    </Popconfirm>
                                </Tooltip>
                            </>
                        )}


                    </Space>

                </>
            ),
        },
    ];


    return (
        <>
            <div className="flex items-center mt-2 mb-4">
                <Title level={2} ellipsis>
                    Ordenes de Uso
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