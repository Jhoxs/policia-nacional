import { Space, Tag, Button, Tooltip, Typography, Popconfirm, message, Modal, Input, Select } from 'antd';
import { EditOutlined, DeleteOutlined, EyeOutlined, QuestionCircleOutlined } from '@ant-design/icons';
import collectionColors from '/resources/js/Providers/ColorProvider.js'
import PaginatedTable from '@/Components/PaginatedTable';
import VehiclePreviewInfo from './VehiclePreviewInfo';
import { router, Link, usePage } from '@inertiajs/react';
import React, { useState } from 'react';

const { Title } = Typography;

const { colorVehicles } = collectionColors;


export default function VehicleTable({ modelList }) {
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [modelPreview, setModelPreview] = useState(false);
    const [searchValue, setSearchValue] = useState('');
    const [searchItemValue, setSearchItemValue] = useState({
        value: 'name',
        label: 'Placa'
    });
    const { permissions } = usePage().props?.auth || [];

    const showModal = data => e => {
        setModelPreview(data);
        setIsModalOpen(true);
    };


    const handleCancel = () => {
        setIsModalOpen(false);
    };

    const confirm = data => e => {
        router.delete(route('vehicle.destroy', data), {
            onSuccess: () => {
                message.success('Se vehículo se ha eliminado con éxito');
            }
        });
    }
    
    const cancel = () => {
        message.warning('Se canceló esa acción');
    }

    const columns = [
        {
            title: 'Placa',
            dataIndex: 'plate',
            key: 'plate',
            width: '10%',
        },
        {
            title: 'Chasis',
            dataIndex: 'chassis',
            key: 'chassis',
            width: '12%'
        },
        {
            title: 'Marca',
            dataIndex: 'brand',
            key: 'brand',
            width: '12%'
        },
        {
            title: 'Modelo',
            dataIndex: 'model',
            key: 'model',
            width: '10%'
        },
        {
            title: 'Motor',
            dataIndex: 'motor',
            key: 'motor',
            width: '10%'
        },
        {
            title: 'Kilometraje',
            dataIndex: 'mileage',
            key: 'mileage',
            width: '12%'
        },
        {
            title: 'Tipo de Vehículo',
            dataIndex: 'vehicle_type',
            width: '10%',
            key: 'vehicle_type',
            render: (_, { vehicle_type }) => {
                let color;
                color = colorVehicles[vehicle_type.toUpperCase()] || 'blue'

                return (
                    <>
                        <Tag color={color} key={vehicle_type}>
                            {vehicle_type.toUpperCase()}
                        </Tag>
                    </>
                );
            },
        },
        {
            title: 'Acciones',
            key: 'action',
            align: 'center',
            width: '15%',
            render: (_, record) => (
                <>
                    <Space size="small">

                        <Tooltip title={'Vista Previa'}>
                            <Button size='small' shape='round' icon={<EyeOutlined />} onClick={showModal(record)} />
                        </Tooltip>

                        {permissions.includes('vehicle.edit') && (
                            <>
                                <Link href={route('vehicle.edit', record.key)}>
                                    <Tooltip title={'Editar'}>
                                        <Button size='small' shape='round' className="bg-[#203956]" type='primary' icon={<EditOutlined />} />
                                    </Tooltip>
                                </Link>
                            </>
                        )}

                        {permissions.includes('vehicle.destroy') && (
                            <>
                                <Tooltip title={'Eliminar'}>
                                    <Popconfirm
                                        title='Eliminación del Vehículo'
                                        description={"¿Está seguro que desea eliminar el vehículo con matriculta " + record.plate + " ?"}
                                        okText='Si'
                                        cancelText='No'
                                        icon={<QuestionCircleOutlined style={{ color: 'red' }} />}
                                        okButtonProps={{ danger: true, size: 'middle' }}
                                        cancelButtonProps={{ size: 'middle' }}
                                        onConfirm={confirm(record.key)}
                                        onCancel={cancel}
                                    >
                                        <Button size='small' type="primary" danger shape='round' icon={<DeleteOutlined />} />
                                    </Popconfirm>
                                </Tooltip>
                            </>
                        )}

                    </Space>
                </>
            ),
        },
    ];

    const options = [
        {
            label: 'Placa',
            value: 'plate'
        }, {
            label: 'Chasis',
            value: 'chassis'
        }, {
            label: 'Marca',
            value: 'brand'
        }, {
            label: 'Motor',
            value: 'motor'
        }, {
            label: 'Kilometraje',
            value: 'mileage'
        }, {
            label: 'Capacidad de Cilindraje',
            value: 'cylinder_capacity'
        }, {
            label: 'Tipo de Vehículo',
            value: 'vehicle_type_id'
        }
    ];

    const handleSeach = (value, itemValue) => {
        const iValue = itemValue.value || itemValue;
        router.visit(route('user.index', { value: value, key: iValue }), {
            preserveState: true,
            method: 'get'
        })
    }


    return (
        <>
            <Modal
                style={{ top: 20 }}
                open={isModalOpen}
                closable={false}
                onCancel={handleCancel}
                okButtonProps={{
                    hidden: true,
                }}
                cancelButtonProps={{
                    hidden: true,
                }}
            >
                <VehiclePreviewInfo modelPreview={modelPreview} />

            </Modal>

            <div className="flex items-center mt-2 mb-4">
                <Title level={2} ellipsis>
                    Vehículos
                </Title>
                <h1 className="flex-1 border-b-2 border-gray-100"></h1>
            </div>

            <div className="flex justify-end mb-3 ">
                <Space.Compact size='large'>
                    <Select
                        options={options}
                        defaultValue={options[0]}
                        onChange={value => setSearchItemValue(value)}
                    />
                    <Input.Search
                        value={searchValue}
                        onChange={e => setSearchValue(e.target.value)}
                        onSearch={value => handleSeach(value, searchItemValue)}
                    />
                </Space.Compact>
            </div>

            <PaginatedTable
                columns={columns}
                dataTable={modelList}
            ></PaginatedTable>
        </>
    );
}