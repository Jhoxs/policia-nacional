import { Typography, Button, Divider, Form, Input, Checkbox, Row, Col, Space, Card, Cascader, Select, Transfer } from 'antd';
import { Head, Link, router, useForm, usePage } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { MailOutlined, CarOutlined, VerifiedOutlined, IdcardOutlined, EnvironmentOutlined } from '@ant-design/icons';

const { Text, Title } = Typography;


const Edit = ({ subcircuitInfo, modelInfo, userList }) => {

    const gridStyle = {
        width: '100%',
        padding: '17px'

    };

    const userInfo = modelInfo.data;
    const { permissions } = usePage().props?.auth || [];
    const uList = userList?.data || [];
    const [selectedValues, setSelectedValues] = useState(userInfo.user_list || []);

    const handleSelectChange = (values) => {
        if (values.length <= 4) {
            setSelectedValues(values);
        }
    };

    const { data, setData, patch, processing, errors } = useForm({
        userVehicle: userInfo.user_list || [],

    });
    
    const submit = (e) => {
        //console.log(e);
        patch(route('uservehicle.update', userInfo.key), {
            preserveScroll:true,
            onSuccess: () => {
            }
        });
    };

    return (
        <>
            <div className="flex items-center mt-2 mb-4">
                <Title level={1} ellipsis>
                    Asignación Vehículo Usuario
                </Title>
                <h1 className="flex-1 border-b-2 border-gray-100"></h1>
            </div>
            <div className="flex justify-center mt-5'">
                <Card.Grid className='flex justify-center shadow-md' style={{ maxWidth: 800, width: 550, padding: 15, borderRadius: 12, overflowX: 'scroll' }}>
                    <Row>
                        <Card style={{ cursor: 'inherit', width: '100%' }} hoverable={false} title={<Title className='mt-3' level={4}>Información Básica</Title>} className='mt-4 mb-10' type='inner'>
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
                            <Card.Grid style={gridStyle}>
                                <Space size={20}>
                                    <EnvironmentOutlined style={{ fontSize: '30px' }} />
                                    <div className='sm:block'>
                                        <div>
                                            <Text strong>{userInfo?.cities} </Text>
                                        </div>
                                        <div>Distrito/Ciudad</div>
                                    </div>
                                </Space>
                            </Card.Grid>
                            <Card.Grid style={gridStyle}>
                                <Space size={20}>
                                    <EnvironmentOutlined style={{ fontSize: '30px' }} />
                                    <div className='sm:block'>
                                        <div>
                                            <Text strong>{userInfo?.subcirtuit} </Text>
                                        </div>
                                        <div>Subcircuito</div>
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
                            style={{ width: '100%' }}

                        >
                            <Form.Item
                                name="userVehicle"
                                label="Usuarios (Identificación)"
                                validateStatus={errors.userVehicle && 'error'}
                                help={errors.userVehicle}
                            >
                                <Select
                                    size='large'
                                    mode='tags'
                                    placeholder='Usuarios del distrito disponibles'
                                    options={uList}
                                    onChange={handleSelectChange}
                                >
                                </Select>
                            </Form.Item>


                            <Row justify={'center'} align={'middle'} gutter={['10', '10']} className='mt-4'>
                                <Col>
                                    <Link href={route('uservehicle.index')}>
                                        <Button
                                            size="large"
                                            className="mt-5 shadow-md"
                                        >
                                            Volver
                                        </Button>
                                    </Link>
                                </Col>
                                <Col>
                                    {permissions.includes('uservehicle.update') && (
                                        <>
                                            <Button
                                                type="primary"
                                                htmlType="submit"
                                                loading={processing}
                                                size="large"
                                                className="mt-5 bg-[#203956]"
                                                disabled={(uList.length == 0 && userInfo.user_list.length == 0 ) || (selectedValues.length > 4)}
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