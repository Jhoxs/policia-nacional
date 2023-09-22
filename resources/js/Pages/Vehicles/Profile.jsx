import { PlusOutlined, DashboardOutlined } from '@ant-design/icons';
import { Typography, Button, Divider, Form, Input, Checkbox, Row, Col, Space, Card, DatePicker, Select } from 'antd';
import { Link, usePage, useForm } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import VehicleTable from './Partials/VehicleTable';
import VehiclePreviewInfo from './Partials/VehiclePreviewInfo';

const { Text, Title } = Typography;

const Profile = ({ vehicleInfo }) => {

    const { permissions } = usePage().props?.auth || [];
    const vehicleData = vehicleInfo?.data;

    const { data, setData, patch, processing, errors } = useForm({

        mileage: vehicleData?.mileage,

    });

    const submit = (e) => {
        patch(route('profile-vehicle.edit', vehicleData?.key), {
            onSuccess: () => {
            }
        });
    };

    return (
        <>
            <div className="flex items-center mt-2 mb-4">
                <Title level={1} ellipsis>
                    Perfil del Vehículo
                </Title>
                <h1 className="flex-1 border-b-2 border-gray-100"></h1>
            </div>
            <Row gutter={[16, 16]}>
                <Col xs={24} sm={24} md={18} lg={16} xl={16} xxl={16}>
                    <Card>
                        <VehiclePreviewInfo modelPreview={vehicleData} />
                    </Card>
                </Col>
                <Col xs={24} sm={24} md={6} lg={8} xl={8} xxl={8}>
                    <Card title={<Title style={{ textAlign: 'center' }} className='mt-3' level={4}>Actualización del Kilometraje</Title>} >
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
                        >
                            <Form.Item
                                label='Kilometraje Actual'
                                name='mileage'
                                validateStatus={errors.mileage && 'error'}
                                help={errors.mileage}
                                className='mb-4'
                            >
                                <Input size='large' prefix={<DashboardOutlined />}></Input>
                            </Form.Item>

                            <Row justify={'center'} align={'middle'} gutter={['10', '10']} className='mt-4'>

                                <Col>
                                    <Button
                                        style={{margin:5}}
                                        htmlType="submit"
                                        loading={processing}
                                        size="large"
                                        
                                    >
                                        Actualizar
                                    </Button>
                                </Col>
                            </Row>
                        </Form>
                    </Card>
                </Col>
            </Row>

        </>

    );
}

Profile.layout = page => (<AuthenticatedLayout title="Perfil Vehículo" children={page} />)


export default Profile
