import { Card, Row, Col, Button, Statistic, message, Popconfirm, App } from 'antd';
import { QuestionCircleOutlined } from '@ant-design/icons';
import { UserOutlined } from '@ant-design/icons';
import { useState } from 'react';
import { usePage, router, Link } from '@inertiajs/react';

const RolCard = ({ rol }) => {

    const { permissions } = usePage().props?.auth || [];

    const confirm = (e) => {
        router.delete(route('rol.destroy', rol.id), {
            onSuccess: () => {
                message.success('Se ha eliminado con éxito el registro');
            }
        });
    }

    const cancel = (e) => {
        message.warning('Se canceló esa acción');
    }

    return (
        <>
            <Card size='small' title={rol.name} className='shadow-md'>
                <Statistic title="Total de Usuarios" value={rol.users_count} prefix={<UserOutlined />} />

                <Row justify={'center'} align={'middle'} gutter={['10', '10']} className='mt-4'>
                    <Col className='mt-1'>
                        {permissions.includes('rol.edit') && (
                            <>
                                <Link href={route('rol.edit', rol.id)}>
                                    <Button type="primary" className="bg-[#203956]" >
                                        Editar
                                    </Button>
                                </Link>
                            </>
                        )}
                    </Col>
                    <Col className='mt-1'>
                        {permissions.includes('rol.destroy') && (
                            <>
                                <Popconfirm
                                    title='Eliminación del Rol'
                                    description={"¿Está seguro que desea eliminar el rol de " + rol.name + "?"}
                                    okText='Si'
                                    cancelText='No'
                                    icon={<QuestionCircleOutlined style={{ color: 'red' }} />}
                                    okButtonProps={{ danger: true, size: 'middle' }}
                                    cancelButtonProps={{ size: 'middle' }}
                                    onConfirm={confirm}
                                    onCancel={cancel}
                                >
                                    <Button type="primary" danger >
                                        Eliminar
                                    </Button>
                                </Popconfirm>
                            </>
                        )}
                    </Col>
                </Row>
            </Card>
        </>
    );
};

export default RolCard