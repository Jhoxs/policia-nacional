import { Space, Tag, Button, Tooltip, Typography, Popconfirm, message, Modal, Input, Select } from 'antd';
import { EditOutlined, DeleteOutlined, EyeOutlined, QuestionCircleOutlined } from '@ant-design/icons';
import collectionColors from '/resources/js/Providers/ColorProvider.js'
import PaginatedTable from '@/Components/PaginatedTable';
import UserPreviewInfo from './UserPreviewInfo';
import { router, Link, usePage } from '@inertiajs/react';
import React, { useState } from 'react';

const { Title, Text } = Typography;

const { colorRoles } = collectionColors;





export default function UsersTable({ userList }) {
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [userPreview, setUserPreview] = useState(false);
    const [searchValue, setSearchValue] = useState('');
    const [rejectedReason, setRejectedReason] = useState('');
    const [searchItemValue, setSearchItemValue] = useState({
        value: 'name',
        label: 'Nombres'
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

        const info = {
            id: data,
            reason: rejectedReason,
            typeRequest: 'reject'
        }
        
        router.delete(route('user.destroy', info), {
            onSuccess: () => {
                //message.success('Se ha eliminado el usuario con éxito');
            }
        });
    }

    const cancel = () => {
        //message.warning('Se canceló esa acción');
    }

    const columns = [
        {
            title: 'Identificación',
            dataIndex: 'identification',
            key: 'identification',
            width: '10%',
        },
        {
            title: 'Nombres',
            dataIndex: 'name',
            key: 'name',
            width: '12%'
        },
        {
            title: 'Apellidos',
            dataIndex: 'last_name',
            key: 'last_name',
            width: '12%'
        },
        {
            title: 'Teléfono',
            dataIndex: 'phone',
            key: 'phone',
            width: '10%'
        },
        {
            title: 'Rango',
            dataIndex: 'rank',
            key: 'rank',
            width: '10%'
        },
        {
            title: 'Tipo de Sangre',
            dataIndex: 'blood_type',
            key: 'blood_type',
            width: '12%'
        },
        {
            title: 'Ciudad',
            dataIndex: 'city',
            key: 'city',
            width: '10%'
        },
        {
            title: 'Roles',
            key: 'roles',
            dataIndex: 'roles',
            with: '10%',
            render: (_, { roles }) => (
                <>
                    {roles.map((rol) => {
                        let color;

                        color = colorRoles[rol.toUpperCase()] || 'blue'

                        return (
                            <Tag color={color} key={rol}>
                                {rol.toUpperCase()}
                            </Tag>
                        );
                    })}
                </>
            ),
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

                        {permissions.includes('user.edit') && (
                            <>
                                <Link href={route('user.edit', record.key)}>
                                    <Tooltip title={'Editar'}>
                                        <Button size='small' shape='round' className="bg-[#203956]" type='primary' icon={<EditOutlined />} />
                                    </Tooltip>
                                </Link>
                            </>
                        )}

                        {permissions.includes('user.destroy') && (
                            <>
                                <Tooltip title={'Eliminar'}>
                                    <Popconfirm
                                        title='Eliminación del Rol'
                                        description={
                                            <>
                                                <Text>
                                                    {"¿Está seguro que desea eliminar al usuario " + record.full_name + " con identificación " + record.identification + " ?"}
                                                </Text>
                                                <Input.TextArea
                                                    placeholder='Escriba el motivo...'
                                                    className='mt-3 mb-3'
                                                    maxLength={255}
                                                    value={rejectedReason}
                                                    onChange={e => setRejectedReason(e.target.value)}
                                                />
                                            </>
                                        }
                                        okText='Si'
                                        cancelText='No'
                                        icon={<QuestionCircleOutlined style={{ color: 'red' }} />}
                                        okButtonProps={{ danger: true, size: 'middle' }}
                                        cancelButtonProps={{ size: 'middle' }}
                                        onConfirm={confirm(record.key)}
                                        onCancel={cancel}
                                        onClick={() => setRejectedReason('')}
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
            label: 'Nombres',
            value: 'name'
        }, {
            label: 'Identificación',
            value: 'identification'
        }, {
            label: 'Roles',
            value: 'roles'
        }, {
            label: 'Rangos',
            value: 'rank'
        }, {
            label: 'Ciudad',
            value: 'city'
        }, {
            label: 'Tipo de Sangre',
            value: 'blood_type'
        }, {
            label: 'Email',
            value: 'email'
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
                style={{ top: 34 }}
                open={isModalOpen}
                closable={false}
                onCancel={handleCancel}
                okButtonProps={{
                    hidden: true,
                }}
                cancelButtonProps={{
                    hidden: true,
                }}
            /* width={'90%'} */
            >
                <UserPreviewInfo userPreview={userPreview} />

            </Modal>

            <div className="flex items-center mt-2 mb-4">
                <Title level={2} ellipsis>
                    Usuarios
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
                dataTable={userList}
            ></PaginatedTable>
        </>
    );
}