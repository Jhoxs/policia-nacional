
import { Space, Tag, Button, Tooltip, Typography, Popconfirm, message, Modal, Avatar, Card } from 'antd';
import { PhoneOutlined, UserOutlined, MailOutlined, IdcardOutlined, HeartOutlined, AlertOutlined, EnvironmentOutlined, GiftOutlined } from '@ant-design/icons';
const { Title, Text } = Typography;

export default function UserPreviewInfo({ userPreview }) {

    const gridStyle = {
        width: '100%',
        padding: '10px'

    };

    return (
        <>
            <div className="flex justify-center">
                <Title level={3}>
                    Información General
                </Title>
            </div>
            <div className='mt-2'>
                <Card>
                    <Card.Grid style={gridStyle}>
                        <Space size={20}>
                            <IdcardOutlined style={{ fontSize: '30px' }} />
                            <div className='sm:block'>
                                <div>
                                    <Text strong>{userPreview.identification} </Text>
                                </div>
                                <div>Identificación</div>
                            </div>
                        </Space>
                    </Card.Grid>
                    <Card.Grid style={gridStyle}>
                        <Space size={20}>
                            <UserOutlined style={{ fontSize: '30px' }} />
                            <div className='sm:block'>
                                <div>
                                    <Text strong>{userPreview.name} {userPreview.last_name} </Text>
                                </div>
                                <div>Nombre del Usuario</div>
                            </div>
                        </Space>
                    </Card.Grid>
                    <Card.Grid style={gridStyle}>
                        <Space size={20}>
                            <MailOutlined style={{ fontSize: '30px' }} />
                            <div className='sm:block'>
                                <div>
                                    <Text strong>{userPreview.email} </Text>
                                </div>
                                <div>Correo Electrónico</div>
                            </div>
                        </Space>
                    </Card.Grid>
                    <Card.Grid style={gridStyle}>
                        <Space size={20}>
                            <PhoneOutlined style={{ fontSize: '30px' }} />
                            <div className='sm:block'>
                                <div>
                                    <Text strong>{userPreview.phone} </Text>
                                </div>
                                <div>Teléfono</div>
                            </div>
                        </Space>
                    </Card.Grid>
                    <Card.Grid style={gridStyle}>
                        <Space size={20}>
                            <HeartOutlined style={{ fontSize: '30px' }} />
                            <div className='sm:block'>
                                <div>
                                    <Text strong>{userPreview.blood_type} </Text>
                                </div>
                                <div>Tipo de Sangre</div>
                            </div>
                        </Space>
                    </Card.Grid>
                    <Card.Grid style={gridStyle}>
                        <Space size={20}>
                            <EnvironmentOutlined style={{ fontSize: '30px' }} />
                            <div className='sm:block'>
                                <div>
                                    <Text strong>{userPreview.city} </Text>
                                </div>
                                <div>Ciudad</div>
                            </div>
                        </Space>
                    </Card.Grid>
                    <Card.Grid style={gridStyle}>
                        <Space size={20}>
                            <AlertOutlined style={{ fontSize: '30px' }} />
                            <div className='sm:block'>
                                <div>
                                    <Text strong>{userPreview.rank} </Text>
                                </div>
                                <div>Rango</div>
                            </div>
                        </Space>
                    </Card.Grid>
                    <Card.Grid style={gridStyle}>
                        <Space size={20}>
                            <GiftOutlined style={{ fontSize: '30px' }} />
                            <div className='sm:block'>
                                <div>
                                    <Text strong>{userPreview.birthdate} </Text>
                                </div>
                                <div>Fecha de Nacimiento</div>
                            </div>
                        </Space>
                    </Card.Grid>
                </Card>
            </div>

        </>
    );
}