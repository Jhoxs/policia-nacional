import { Button, Dropdown, Avatar } from 'antd';
import { UserOutlined } from '@ant-design/icons';
import AliasDropdown  from '@/Components/Dropdown';
import { Link } from '@inertiajs/react';

export default function CustomAvatar({ children, ...props }) {
    const items = [
        {
            key: '1',
            label: (
                <Link href={route('profile.edit')} as="button">
                    Perfil
                </Link>

                
            ),
        },
        {
            key: '2',
            label: (
                <Link href={route('logout')} method="post" as="button">
                    Cerrar Sesión
                </Link>
                
            ),
        },
    ];

    return (
        <>
            <Dropdown
                menu={{
                    items,
                }}
                placement="bottomLeft"
                arrow
            >
                <Avatar size="large" icon={<UserOutlined />} />
            </Dropdown>
        </>
    );
}