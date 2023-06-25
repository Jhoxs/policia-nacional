
import { PlusOutlined } from '@ant-design/icons';
import { Typography, Button, Modal } from 'antd';
import { useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import RolWithUser from './Partials/RolWithUser';
import RolList from './Partials/RolList';
import Create from './Create';

const { Text, Title } = Typography;

const Index = ({ rolList, userList }) => {

    const [open, setOpen] = useState(false);

    const showModal = () => {
        setOpen(true);
    };

    const hideModal = () => {
        setOpen(false);
    };

    const roles = rolList?.data;

    return (
        <>
            <div className='flex justify-end'>
                <Button
                    type="primary"
                    size="large"
                    className="bg-[#52c41a] hover:bg-blue-100"
                    icon={<PlusOutlined />}
                    onClick={showModal}
                >
                    Crear Rol
                </Button>
                <Modal
                    open={open}
                    onOk={hideModal}
                    onCancel={hideModal}
                    okButtonProps={{ hidden: true }}
                    cancelButtonProps={{ hidden: true }}
                    closable={false}
                    width={'40rem'}
                >
                    <Create/>
                </Modal>
            </div>

            <RolList
                roles={roles}
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
