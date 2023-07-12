import { Typography, Button, Divider, Form, Input, Checkbox, Row, Col, Space, Card, Cascader, Select } from 'antd';
import { Head, Link, router, useForm, usePage } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { MailOutlined, CarOutlined, VerifiedOutlined, IdcardOutlined } from '@ant-design/icons';

const { Text, Title } = Typography;


const Edit = ({ provinces, subcircuitInfo, modelInfo }) => {

    const gridStyle = {
        width: '100%',
        padding: '17px'

    };

    const userInfo = modelInfo.data;
    const { dependences } = subcircuitInfo?.data || [];
    const proviceData = provinces?.data;
    const { permissions } = usePage().props?.auth || [];

    const filter = (inputValue, path) =>
        path.some((option) => option.label.toLowerCase().indexOf(inputValue.toLowerCase()) > -1);

    const { data, setData, patch, processing, errors } = useForm({
        dependence: dependences,

    });

    const submit = (e) => {
        //console.log(e);
        patch(route('subvehicle.update', userInfo.key), {
            onSuccess: () => {
            }
        });
    };

    return (
        <>
            <div className="flex items-center mt-2 mb-4">
                <Title level={1} ellipsis>
                    Asignación Subcircuito Vehículo
                </Title>
                <h1 className="flex-1 border-b-2 border-gray-100"></h1>
            </div>
            <div className="flex justify-center mt-5'">
                <Card.Grid className='flex justify-center shadow-md' style={{ maxWidth: 800, width: 550, padding: 15, borderRadius: 12, overflowX:'scroll' }}>
                    <Row>
                        <Card style={{ cursor: 'inherit', width:'100%' }} hoverable={false} title={<Title className='mt-3' level={4}>Información Básica</Title>} className='mt-4 mb-10' type='inner'>
                            <Card.Grid style={gridStyle}>
                                <Space size={20}>
                                    <IdcardOutlined style={{ fontSize: '30px' }} />
                                    <div className='sm:block'>
                                        <div>
                                            <Text strong>{userInfo?.plate} </Text>
                                        </div>
                                        <div>Placa</div>
                                    </div>
                                </Space>
                            </Card.Grid>
                            <Card.Grid style={gridStyle}>
                                <Space size={20}>
                                    <VerifiedOutlined style={{ fontSize: '30px' }} />
                                    <div className='sm:block'>
                                        <div>
                                            <Text strong>{userInfo?.brand} </Text>
                                        </div>
                                        <div>Marca</div>
                                    </div>
                                </Space>
                            </Card.Grid>
                            <Card.Grid style={gridStyle}>
                                <Space size={20}>
                                    <CarOutlined style={{ fontSize: '30px' }} />
                                    <div className='sm:block'>
                                        <div>
                                            <Text strong>{userInfo?.vehicle_type_name} </Text>
                                        </div>
                                        <div>Tipo Vehículo</div>
                                    </div>
                                </Space>
                            </Card.Grid>
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
                            scrollToFirstError
                            className='m-4 w-full'
                            style={{width:'100%'}}

                        >
                            <Form.Item
                                label='Provincias / Ciudades / Parroquias / Circuitos / Subcircuito'
                                name='dependence'
                                validateStatus={errors.dependence && 'error'}
                                help={errors.dependence}
                                className='mb-4'
                            >
                                <Cascader
                                    options={proviceData}
                                    size='large'
                                    placeholder='Selecciona un Subcircuito'
                                    showSearch={{ filter }}
                                />
                            </Form.Item>

                            <Row justify={'center'} align={'middle'} gutter={['10', '10']} className='mt-4'>
                                <Col>
                                    <Link href={route('subvehicle.index')}>
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
                                    {permissions.includes('subvehicle.update') && (
                                        <>
                                            <Button
                                                type="primary"
                                                htmlType="submit"
                                                loading={processing}
                                                size="large"
                                                className="mt-5 bg-[#203956]"
                                            >
                                                Asignar
                                            </Button>
                                        </>
                                    )}
                                </Col>
                            </Row>


                        </Form>
                    </Row>
                </Card.Grid>
            </div>
        </>
    );
}

Edit.layout = page => (<AuthenticatedLayout title="Editar Dependencias" children={page} />)


export default Edit