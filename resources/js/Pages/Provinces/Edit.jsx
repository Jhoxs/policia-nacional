import { Typography, Button, Divider, Form, Input, Checkbox, Row, Col, Space, Card, Cascader, Select } from 'antd';
import { Head, Link, router, useForm, usePage } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { MailOutlined, UserOutlined, PhoneOutlined } from '@ant-design/icons';

const { Text, Title } = Typography;


const Edit = ({ provinces, modelInfo }) => {

    const { code, display_name, dependences, key} = modelInfo.data;
    const proviceData = provinces?.data;
    const { permissions } = usePage().props?.auth || [];

    const filter = (inputValue, path) =>
        path.some((option) => option.label.toLowerCase().indexOf(inputValue.toLowerCase()) > -1);

    const { data, setData, patch, processing, errors } = useForm({
        display_name: display_name

    });

    const submit = (e) => {
        // console.log(e);
        patch(route('province.update',key), {
            onSuccess: () => {
            }
        });
    };

    return (
        <>
            <div className="flex items-center mt-2 mb-4">
                <Title level={1} ellipsis>
                    Edición de Provincia
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
                            label='Nombre Provincia'
                            name='display_name'
                            validateStatus={errors.display_name && 'error'}
                            help={errors.display_name}
                            className='mb-4'
                        >
                            <Input size='large' ></Input>
                        </Form.Item>



                        <Row justify={'center'} align={'middle'} gutter={['10', '10']} className='mt-4'>
                            <Col>
                                <Link href={route('province.index')}>
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
                                {permissions.includes('province.update') && (
                                    <>
                                        <Button
                                            type="primary"
                                            htmlType="submit"
                                            loading={processing}
                                            size="large"
                                            className="mt-5 bg-[#203956]"
                                        >
                                            Actualizar
                                        </Button>
                                    </>
                                )}
                            </Col>
                        </Row>


                    </Form>
                </Card.Grid>
            </div>
        </>
    );
}

Edit.layout = page => (<AuthenticatedLayout title="Editar Dependencias" children={page} />)


export default Edit