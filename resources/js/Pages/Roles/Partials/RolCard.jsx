import { Card, Row, Col, Button, Statistic, Modal } from 'antd';
import { UserOutlined } from '@ant-design/icons';
import { useState } from 'react';

export default function RolCard({ rol }) {
    const [open, setOpen] = useState(false);

    const showModal = () => {
        setOpen(true);
    };

    const hideModal = () => {
        setOpen(false);
    };

    return (
        <Card size='small' title={rol.name} className='shadow-md'>
            <Statistic title="Total de Usuarios" value={rol.users_count} prefix={<UserOutlined />} />

            <Row justify={'center'} align={'middle'} gutter={['10', '10']} className='mt-4'>
                <Col className='mt-1'>
                    <Button type="primary" className="bg-[#203956]" onClick={showModal}>
                        Editar
                    </Button>
                    <Modal
                        open={open}
                        onOk={hideModal}
                        onCancel={hideModal}
                        okButtonProps={{ hidden: true }}
                        cancelButtonProps={{ hidden: true }}
                        closable={false}
                        width={'60%'}
                    >


                    </Modal>
                </Col>
                <Col className='mt-1'>
                    <Button type="primary" danger >
                        Eliminar
                    </Button>
                </Col>
            </Row>
        </Card>
    );

}