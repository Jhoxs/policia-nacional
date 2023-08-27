import { Space, Tag, Button, Tooltip, Typography, Popconfirm, message, Input, Select } from 'antd';
import { EditOutlined, DeleteOutlined, EyeOutlined, QuestionCircleOutlined } from '@ant-design/icons';
import collectionColors from '/resources/js/Providers/ColorProvider.js'
import PaginatedTable from '@/Components/PaginatedTable';
import { router, Link, usePage } from '@inertiajs/react';
import React, { useState } from 'react';

const { Title } = Typography;

const { colorRoles } = collectionColors;


export default function ModelTable({ modelList }) {

    const [searchValue, setSearchValue] = useState('');
    const [searchItemValue, setSearchItemValue] = useState({
        value: 'name',
        label: 'Nombre'
    });
    const { permissions } = usePage().props?.auth || [];

    const showModal = data => e => {
        setUserPreview(data);
        setIsModalOpen(true);
    };


    const handleCancel = () => {
        setIsModalOpen(false);
    };

    const confirm = data => e => {
        router.delete(route('spare.destroy', data), {
            onSuccess: () => {
                //message.success('Se ha eliminado el usuario con éxito');
            }
        });
    }

    const cancel = () => {
        message.warning('Se canceló esa acción');
    }

    const columns = [
        {
            title: 'Nombre',
            dataIndex: 'name',
            key: 'name',
            width: '20%'
        },
        {
            title: 'Marca',
            dataIndex: 'brand',
            key: 'brand',
            width: '20%'
        },
        {
            title: 'Precio',
            dataIndex: 'price',
            key: 'price',
            width: '15%'
        },
        {
            title: 'Detalle',
            dataIndex: 'detail',
            key: 'detail',
            width: '25%'
        },
        {
            title: 'Acciones',
            key: 'action',
            align: 'center',
            width: '20%',
            render: (_, record) => (
                <>
                    <Space size="small">

                        {permissions.includes('spare.edit') && (
                            <>
                                <Link href={route('spare.edit', record.key)}>
                                    <Tooltip title={'Editar'}>
                                        <Button size='middle' shape='round' className="bg-[#203956]" type='primary' icon={<EditOutlined />} />
                                    </Tooltip>
                                </Link>
                            </>
                        )}

                        {permissions.includes('spare.destroy') && (
                            <>
                                <Tooltip title={'Eliminar'}>
                                    <Popconfirm
                                        title='Eliminación del Rol'
                                        description={"¿Está seguro que desea eliminar el repuesto?"}
                                        okText='Si'
                                        cancelText='No'
                                        icon={<QuestionCircleOutlined style={{ color: 'red' }} />}
                                        okButtonProps={{ danger: true, size: 'middle' }}
                                        cancelButtonProps={{ size: 'middle' }}
                                        onConfirm={confirm(record.key)}
                                        onCancel={cancel}
                                    >
                                        <Button size='middle' type="primary" danger shape='round' icon={<DeleteOutlined />} />
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
            label: 'Nombre',
            value: 'name'
        }, {
            label: 'Marca',
            value: 'brand'
        }
    ];

    const handleSeach = (value, itemValue) => {
        const iValue = itemValue.value || itemValue;
        router.visit(route('spare.index', { value: value, key: iValue }), {
            preserveState: true,
            method: 'get'
        })
    }


    return (
        <>
            <div className="flex items-center mt-2 mb-4">
                <Title level={2} ellipsis>
                    Repuestos
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