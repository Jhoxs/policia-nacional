
import { PlusOutlined } from '@ant-design/icons';
import { Button, message } from 'antd';
import { Link, usePage } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import RolWithUser from './Partials/RolWithUser';
import RolList from './Partials/RolList';


const Index = ({ rolList, userList }) => {

    const { data } = rolList;
    
    return (
        <> 
            <div className='flex justify-end'>
                <Link href={route('rol.create')}>
                    <Button
                        type="primary"
                        size="large"
                        className="bg-[#52c41a] hover:bg-blue-100"
                        icon={<PlusOutlined />}
                    >
                        Crear Rol
                    </Button>
                </Link>

            </div>

            <RolList
                roles={data}
            ></RolList>

            <div className="mt-12 ">
                <RolWithUser
                    userList={userList}
                ></RolWithUser>
            </div>
        </>
    )
}


Index.layout = page => (<AuthenticatedLayout title="Roles" children={page} />)


export default Index
