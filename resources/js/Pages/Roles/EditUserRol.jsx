import { Typography, Button, Divider, Form, Input, Checkbox, Row, Col, Space, Card, Select } from 'antd';
import { Head, Link, router, useForm } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

const { Text, Title } = Typography;


const EditUserRol = ({ userRol, userInfo, rolList }) => {

    const full_name = userInfo?.name + ' ' + userInfo?.last_name;
    const { data, setData, patch, processing, errors } = useForm({
        roles: userRol
    });

    useEffect(() => {
        return () => {
        }
    });

    const submit = (e) => {
        patch(route('rol.updateUserRol', userInfo.id), {
            onSuccess: () => {
            }
        });

    };

    return (
        <>
            <div className="flex items-center mt-2 mb-4">
                <Title level={1} ellipsis>
                    Edición Rol Usuario
                </Title>
                <h1 className="flex-1 border-b-2 border-gray-100"></h1>
            </div>
            <div className="flex justify-center mt-5'">
                <Card className='flex justify-center shadow-md' style={{ width: '60vw' }}>
                    <Card style={{ cursor: 'inherit' , width:'55vw'}}  hoverable={true} title={<Title className='mt-3' level={4}>Información Básica</Title>} className='mt-4 mb-10' type='inner'>
                        <div className="flex items-center mt-2">
                            <div className="w-2/3">
                                <Text strong>
                                    Nombre Completo
                                </Text>
                            </div>
                            <div className="w-2/3">
                                <Text>
                                    {full_name}
                                </Text>
                            </div>
                        </div>
                        <div className="flex items-center mt-4 mb-2">
                            <div className="w-2/3">
                                <Text strong>
                                    Identificación
                                </Text>
                            </div>
                            <div className="w-2/3">
                                <Text>
                                    {userInfo?.identification}
                                </Text>
                            </div>
                        </div>
                    </Card>

                    <Form
                        name="basic"
                        layout='vertical'
                        initialValues={data}
                        onFieldsChange={(changedFields) => {
                            changedFields.forEach(item => {
                                setData(item.name[0], item.value);
                            })
                        }}
                        onFinish={submit}
                        autoComplete="off"
                        style={{ width: '45vw' }}
                        className='m-4'

                    >
                        <Form.Item
                            name="roles"
                            label="Roles"
                            validateStatus={errors.roles && 'error'}
                            help={errors.roles}
                        >
                            <Select
                                size='large'
                                mode='tags'
                                placeholder='Roles Disponibles'
                                options={rolList}
                            >
                            </Select>
                        </Form.Item>

                        <Row justify={'center'} align={'middle'} gutter={['10', '10']} className='mt-4'>
                            <Col>
                                <Link href={route('rol.index')}>
                                    <Button
                                        loading={processing}
                                        size="large"
                                        className="mt-5 shadow-md"
                                    >
                                        Volver
                                    </Button>
                                </Link>
                            </Col>
                            <Col>
                                <Button
                                    type="primary"
                                    htmlType="submit"
                                    loading={processing}
                                    size="large"
                                    className="mt-5 bg-[#203956]"
                                >
                                    Guardar
                                </Button>
                            </Col>
                        </Row>


                    </Form>
                </Card>
            </div>

        </>

    );
}


EditUserRol.layout = page => (<AuthenticatedLayout title="Editar Rol Usuario" children={page} />)


export default EditUserRol
