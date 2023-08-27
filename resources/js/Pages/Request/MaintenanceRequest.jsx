import { PlusOutlined, EyeOutlined, EditOutlined, QuestionCircleOutlined, CheckOutlined, CloseOutlined } from '@ant-design/icons';
import { Button, Typography, Tooltip, Popconfirm, Space, message, Input } from 'antd';
import { Link, usePage, router } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import PaginatedTable from '@/Components/PaginatedTable';
import { useState } from 'react';

const { Title, Text } = Typography;

const MaintenanceRequest = ({ requestMaintenance }) => {

    const [rejectedReason, setRejectedReason] = useState('');
    const confirm = data => e => {

        const info = {
            idMaintenance: data,
            reasonReject: rejectedReason,
            typeRequest: 'reject'
        }

        router.post(route('requestmaintenance.store', info), {
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
        router.post(route('requestmaintenance.store', info), {
            onSuccess: () => {
                message.success('Se denegó la solicitud de este usuario');
            }
        });
    }


    const columns = [
        {
            title: 'Identificación',
            dataIndex: 'u_identification',
            key: 'u_identification',
            width: '10%',
        },
        {
            title: 'Nombre Usuario',
            dataIndex: 'u_full_name',
            key: 'u_name',
            width: '12%'
        },
        {
            title: 'Placa',
            dataIndex: 'v_plate',
            key: 'v_plate',
            width: '10%'
        },
        {
            title: 'Chasis',
            dataIndex: 'v_chassis',
            key: 'v_chassis',
            width: '10%'
        },
        {
            title: 'Horario Turno',
            dataIndex: 'shift_time',
            key: 'shift_time',
            width: '10%'
        },
        {
            title: 'Fecha Turno',
            dataIndex: 'shift_date',
            key: 'shift_date',
            width: '10%'
        },
        {
            title: 'Observaciones',
            dataIndex: 'details',
            key: 'details',
            width: '10%'
        },
        {
            title: 'Fecha de Creación',
            dataIndex: 'created_at',
            key: 'created_at',
            width: '10%'
        },
        {
            title: 'Acciones',
            key: 'action',
            align: 'center',
            width: '15%',
            render: (_, record) => (
                <>
                    <Space size="small">


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

                    </Space>
                </>
            ),
        },
    ];
    return (
        <>
            <div className="flex items-center mt-2 mb-4">
                <Title level={2} ellipsis>
                    Solicitudes de Mantenimientos
                </Title>
                <h1 className="flex-1 border-b-2 border-gray-100"></h1>
            </div>

            <PaginatedTable
                columns={columns}
                dataTable={requestMaintenance}
            ></PaginatedTable>
        </>
    );
}

MaintenanceRequest.layout = page => (<AuthenticatedLayout title="Solicitudes Mantenimientos" children={page} />)


export default MaintenanceRequest
