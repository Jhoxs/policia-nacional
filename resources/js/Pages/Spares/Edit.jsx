import { Typography, Button, Divider, Form, Input, Checkbox, Row, Col, Space, Card, InputNumber, Select } from 'antd';
import { Head, Link, router, useForm } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { MailOutlined, UserOutlined, PhoneOutlined } from '@ant-design/icons';
import dayjs from 'dayjs';

const { Text, Title } = Typography;


const Edit = ({ roles, cities, blood_types, ranks, modelData }) => {

    const model = modelData?.data;
    const dateFormatted =  dayjs(model?.birthdate_form);

    const { data, setData, patch, processing, errors } = useForm({
        name: model?.name,
        brand: model?.brand,
        price: model?.price,
        detail: model?.detail,
    });

    const submit = (e) => {
        patch(route('spare.update',model?.key), {
            onSuccess: () => {
            }
        });
    };

    return (
        <>
            <div className="flex items-center mt-2 mb-4">
                <Title level={1} ellipsis>
                    Edición de Repuesto
                </Title>
                <h1 className="flex-1 border-b-2 border-gray-100"></h1>
            </div>
            <div className="flex justify-center mt-5'">
                <Card.Grid className='flex justify-center shadow-md' style={{ maxWidth: 800, width: 550, padding: 15, borderRadius: 12 }}>
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
                        scrollToFirstError
                        className='m-4 w-full'

                    >
                         <Form.Item
                            label='Nombre del Repuesto'
                            name='name'
                            validateStatus={errors.name && 'error'}
                            help={errors.name}
                            className='mb-4'
                        >
                            <Input size='large'></Input>
                        </Form.Item>

                        <Form.Item
                            label='Marca'
                            name='brand'
                            validateStatus={errors.brand && 'error'}
                            help={errors.brand}
                            className='mb-4'
                        >
                            <Input size='large'></Input>
                        </Form.Item>

                        <Form.Item
                            label='Precio'
                            name='price'
                            validateStatus={errors.price && 'error'}
                            help={errors.price}
                            className='mb-4'
                        >
                            <InputNumber
                                style={{width:'50%'}} 
                                size='large'
                                prefix="$"
                                min="0"
                                stringMode
                            />
                        </Form.Item>
                        <Form.Item
                            label='Detalles'
                            name='detail'
                            validateStatus={errors.phone && 'error'}
                            help={errors.phone}
                            className='mb-4'
                        >
                            <Input.TextArea size='large'></Input.TextArea>
                        </Form.Item>

                        <Row justify={'center'} align={'middle'} gutter={['10', '10']} className='mt-4'>
                            <Col>
                                <Link href={route('spare.index')}>
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
                                    Actualizar
                                </Button>
                            </Col>
                        </Row>

                    </Form>
                </Card.Grid>
            </div>

        </>

    );
}


Edit.layout = page => (<AuthenticatedLayout title="Editar Repuesto" children={page} />)


export default Edit

