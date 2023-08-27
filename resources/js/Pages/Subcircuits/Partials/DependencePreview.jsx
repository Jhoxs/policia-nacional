import { Space, Tag, Button, Tooltip, Typography, Popconfirm, message, Modal, Avatar, Card } from 'antd';
import { PhoneOutlined, UserOutlined, MailOutlined, IdcardOutlined, HeartOutlined, AlertOutlined, EnvironmentOutlined, GiftOutlined } from '@ant-design/icons';
const { Title, Text } = Typography;

export default function DependencePreview({ modelPreview, customTitle }) {

    const gridStyle = {
        width: '100%',
        padding: '10px'

    };

    return (
        <>
            {!customTitle && (
                <div className="flex justify-center">
                    <Title level={3}>
                        Información General
                    </Title>
                </div>
            )}
            {customTitle && (

                <Title level={customTitle.level || 3}>
                    {customTitle.title || 'Información'}
                </Title>

            )}
            <div className='mt-2'>
                <Card style={customTitle?.style}>
                    <Card.Grid style={gridStyle}  hoverable={!customTitle}>
                        <Space size={20}>
                            <EnvironmentOutlined style={{ fontSize: '30px' }} />
                            <div className='sm:block'>
                                <div>
                                    <Text strong>{modelPreview.province} </Text>
                                </div>
                                <div>Provincia</div>
                            </div>
                        </Space>
                    </Card.Grid>
                    <Card.Grid style={gridStyle}  hoverable={!customTitle}>
                        <Space size={20}>
                            <EnvironmentOutlined style={{ fontSize: '30px' }} />
                            <div className='sm:block'>
                                <div>
                                    <Text strong>{modelPreview.city} </Text>
                                </div>
                                <div>Ciudad / Distrito</div>
                            </div>
                        </Space>
                    </Card.Grid>
                    <Card.Grid style={gridStyle}  hoverable={!customTitle}>
                        <Space size={20}>
                            <EnvironmentOutlined style={{ fontSize: '30px' }} />
                            <div className='sm:block'>
                                <div>
                                    <Text strong>{modelPreview.parish} </Text>
                                </div>
                                <div>Parroquia</div>
                            </div>
                        </Space>
                    </Card.Grid>
                    <Card.Grid style={gridStyle}  hoverable={!customTitle}>
                        <Space size={20}>
                            <EnvironmentOutlined style={{ fontSize: '30px' }} />
                            <div className='sm:block'>
                                <div>
                                    <Text strong>{modelPreview.circuit} </Text>
                                </div>
                                <div>Circuito</div>
                            </div>
                        </Space>
                    </Card.Grid>
                    <Card.Grid style={gridStyle}  hoverable={!customTitle}>
                        <Space size={20}>
                            <EnvironmentOutlined style={{ fontSize: '30px' }} />
                            <div className='sm:block'>
                                <div>
                                    <Text strong>{modelPreview.subcircuit} </Text>
                                </div>
                                <div>Subcircuito</div>
                            </div>
                        </Space>
                    </Card.Grid>
                </Card>
            </div>

        </>
    );
}