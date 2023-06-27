import { Typography, Button, Divider, Form, Input, Checkbox, Row, Col, Space, Card } from 'antd';
import { Head, Link, router, useForm } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

const { Text, Title } = Typography;


const Create = ({ permissionsList }) => {

    const { data, setData, post, processing, errors } = useForm({
        name: '',
        permission: []
    });

    useEffect(() => {
        return () => {
        }
    });

    const submit = (e) => {
        post(route('rol.store'), {
            onSuccess: () => {
            }
        });
    };

    const permissions = permissionsList?.data;

    return (
        <>
            <div className="flex items-center mt-2 mb-4">
                <Title level={1} ellipsis>
                    Creación de Rol
                </Title>
                <h1 className="flex-1 border-b-2 border-gray-100"></h1>
            </div>
            <div className="flex justify-center mt-5'">
                <Card className='flex justify-center shadow-md' style={{ width: '60vw' }}>
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
                            label='Nombre del Rol'
                            name='name'
                            validateStatus={errors.name && 'error'}
                            help={errors.name}
                        >
                            <Input size='large'></Input>
                        </Form.Item>
                        <Form.Item
                            name="permission"
                            label="Permisos Disponibles"
                            validateStatus={errors.permission && 'error'}
                            help={errors.permission}
                        >
                            <Checkbox.Group className='flex justify-center mt-3'>
                                <Row>
                                    {permissions ? (permissions.map((permission) => {
                                        return (
                                            <Col key={permission.id} xl={12} lg={12} md={12} sm={20} xs={24}>
                                                <Checkbox value={permission.name} style={{ lineHeight: '40px' }}>
                                                    {permission.name}
                                                </Checkbox>
                                            </Col>
                                        )
                                    })) : null}
                                </Row>
                            </Checkbox.Group>
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
                                    Guardar Rol
                                </Button>
                            </Col>
                        </Row>


                    </Form>
                </Card>
            </div>

        </>

    );
}


Create.layout = page => (<AuthenticatedLayout title="Crear Rol" children={page} />)


export default Create

