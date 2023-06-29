import { PlusOutlined } from '@ant-design/icons';
import { Button, message } from 'antd';
import { Link, usePage } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import UsersTable from './Partials/UsersTable';

const Index = ({ usersData }) => {

    return (
        <>
            <div className='flex justify-end'>
                <Link href={route('user.create')}>
                    <Button
                        type="primary"
                        size="large"
                        className="bg-[#52c41a] hover:bg-blue-100"
                        icon={<PlusOutlined />}
                    >
                        Crear Usuario
                    </Button>
                </Link>

            </div>

            <div className="mt-12 ">
                <UsersTable
                    userList={usersData}
                ></UsersTable>
            </div>
        </>

    );
}

Index.layout = page => (<AuthenticatedLayout title="Usuarios" children={page} />)


export default Index
