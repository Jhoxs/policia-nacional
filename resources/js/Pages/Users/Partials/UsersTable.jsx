import { Space, Tag, Button, Tooltip, Typography, Popconfirm, message, Modal } from 'antd';
import { EditOutlined, DeleteOutlined, EyeOutlined, QuestionCircleOutlined } from '@ant-design/icons';
import collectionColors from '/resources/js/Providers/ColorProvider.js'
import PaginatedTable from '@/Components/PaginatedTable';
import UserPreviewInfo from './UserPreviewInfo';
import { Link } from '@inertiajs/react';
import React, { useState } from 'react';

const { Title } = Typography;

const { colorRoles } = collectionColors;





export default function UsersTable({ userList }) {
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [userPreview, setUserPreview] = useState(false);

    console.log(userList);

    const showModal = data => e => {
        setUserPreview(data);
        setIsModalOpen(true);
    };


    const handleCancel = () => {
        setIsModalOpen(false);
    };

    const confirm = () => {
        /* router.delete(route('rol.destroy', rol.id), {
            onSuccess: () => {
                message.success('Se ha eliminado con el usuario con éxito');
            }
        }); */
    }

    const cancel = () => {
        message.warning('Se canceló esa acción');
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

                        <Link href={route('rol.show', record.key)}>
                            <Tooltip title={'Editar'}>
                                <Button size='small' shape='round' className="bg-[#203956]" type='primary' icon={<EditOutlined />} />
                            </Tooltip>
                        </Link>

                        <Tooltip title={'Eliminar'}>
                            <Popconfirm
                                title='Eliminación del Rol'
                                description={"¿Está seguro que desea eliminar al usuario " + record.name + " con identificación " + record.identification + " ?"}
                                okText='Si'
                                cancelText='No'
                                icon={<QuestionCircleOutlined style={{ color: 'red' }} />}
                                okButtonProps={{ danger: true, size: 'middle' }}
                                cancelButtonProps={{ size: 'middle' }}
                                onConfirm={confirm}
                                onCancel={cancel}
                            >
                                <Button size='small' type="primary" danger shape='round' icon={<DeleteOutlined />} />
                            </Popconfirm>
                        </Tooltip>

                    </Space>
                </>
            ),
        },
    ];




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

            <PaginatedTable
                columns={columns}
                dataTable={userList}
            ></PaginatedTable>
        </>
    );
}