import { Space, Tag, Button, Tooltip, Typography } from 'antd';
import { EditOutlined } from '@ant-design/icons';
import collectionColors from '/resources/js/Providers/ColorProvider.js'
import PaginatedTable from '@/Components/PaginatedTable';
import { usePage, Link } from '@inertiajs/react';

const { Title } = Typography;

const { colorRoles } = collectionColors;

export default function RolWithUser({ userList }) {

    const { permissions } = usePage().props?.auth || [];
    const canEdit = permissions.includes('rol.updateUserRol');

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
            width: '20%'
        },
        {
            title: 'Apellidos',
            dataIndex: 'last_name',
            key: 'last_name',
            width: '20%'
        },
        {
            title: 'Roles',
            key: 'roles',
            dataIndex: 'roles',
            with: '35%',
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
                        {canEdit && (
                            <>
                                <Link href={route('rol.show', record.key)}>
                                    <Tooltip title={'Editar'}>
                                        <Button shape='round' className="bg-[#203956]" type='primary' icon={<EditOutlined />} />
                                    </Tooltip>
                                </Link>
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
                    Usuarios con Roles
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